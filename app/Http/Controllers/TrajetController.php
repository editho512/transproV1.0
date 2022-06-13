<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\Camion;
use App\Models\Trajet;
use App\Models\Carburant;
use App\Models\Chauffeur;
use App\Models\Itineraire;
use App\Models\TrajetRemorque;
use App\Models\Remorque;
use App\Rules\BonEnlevement;
use App\Rules\Remorque as RemorqueRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;

class TrajetController extends Controller
{
    /**
    * Methode qui ajoute un nouveau trajet dans la base de données
    *
    * @param Request $request Contenant tous les champs
    * @return RedirectResponse Redirection vers la page precedente
    */
    public function add(Request $request) 
    {
        // Validation des données reçues
     
        $data = $request->validate([
                "camion_id" => ['required', 'numeric', 'exists:camions,id'],
                "etat" => ['required', Rule::in(Trajet::getEtat())],
                "chauffeur" => ['nullable', 'exists:chauffeurs,id'],
                "date_heure_depart" => ['required', 'date'],
                "date_heure_arrivee" => ['required', 'date'],
                "carburantRestant" => ['nullable', 'numeric'],
                "poids" => ['nullable', 'numeric' , "min:0"],
                "chargement" => ['required','min:3'],
                "bon" => ['required','min:1'],
                "bon_enlevement" => [new BonEnlevement($request->etat)],
                "remorque" => ['required', new RemorqueRule()]
            ],
            ["remorque.required" => "Le remorque est obligatoire"]    
        );

        $res = [];

        $date_depart = Carbon::parse(date("Y-m-d H:i:s", strtotime($request->date_heure_depart)), 'EAT');
        $date_arrivee = $request->date_heure_arrivee === null ? null : Carbon::parse(date("Y-m-d H:i:s", strtotime($request->date_heure_arrivee)), 'EAT');

        $carburant = collect();
        // Verifier si le camion a un trajet en cours ou non
        $camion = Camion::findOrFail($request->camion_id);
        $chauffeur = Chauffeur::find($request->chauffeur);

        
        if($camion->estDispoEntre($date_depart, $date_arrivee) !== true){

            $res = [
                "value" => "Camion non disponible entre les dates que vous avez selectionnées" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        foreach ($request->remorque as $key => $value) {
           $remorque = Remorque::find($value);

           if($remorque->estDispoEntre($date_depart, $date_arrivee) !== true){
   
               $res = [
                   "value" => "Remorque non disponible entre les dates que vous avez selectionnées" ,
                   "status" => "error"
               ];
   
               return response()->json($res);
           }
        }


        if ($request->chauffeur !== null)
        {
            $chauffeur = Chauffeur::findOrFail($request->chauffeur);
           
            if ($chauffeur->estDispoEntre($date_depart, $date_arrivee) === false AND $request->etat !== Trajet::getEtat(2))
            {
                $res = [
                    "value" => "Chauffeur non disponible entre les dates que vous avez selectionné" ,
                    "status" => "error"
                ];
    
                return response()->json($res);        
            }
        }
        else 
        {
            if ($request->etat !== Trajet::getEtat(0))
            {

                $res = [
                    "value" => "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" ,
                    "status" => "error"
                ];
    
                return response()->json($res);
            }
        }
        

        // Verifier l'etat en fonction de la trajet en cours: Si a un trajet en cours, l'état ne doit pas etre en cours aussi, ou terminé
        if ($camion->aUnTrajetEnCours() AND ($request->etat === Trajet::getEtat(1) OR $request->etat === Trajet::getEtat(2)))
        {
            $res = [
                "value" => "Le camion a encore un trajet en cours" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        if (Carbon::now('EAT')->greaterThanOrEqualTo($date_depart) AND $request->etat === Trajet::getEtat(0))
        {
            
            $res = [
                "value" => "La date de depart doit être supérieur a ce moment précis si le statut est à prévoir" ,
                "status" => "error"
            ];

            return response()->json($res);          
              //dd('La date de depart doit être spérieur a ce moment précis si la status est aprévoir');
        }
        $verifierDate = true;

        // Verifications des dates des trajets
        foreach ($camion->trajets as $trajet)
        {
            $date_dpart_trajet = Carbon::parse($trajet->date_heure_depart, 'EAT');
            $date_arrivee_trajet = Carbon::parse($trajet->date_heure_arrivee, 'EAT');

            if ($date_dpart_trajet->greaterThan($date_depart))
            {
                $verifierDate = ($verifierDate AND false);
            }
            else
            {
                if ($date_arrivee_trajet !== null AND $date_arrivee_trajet->greaterThan($date_depart))
                {
                    $verifierDate = ($verifierDate AND false);
                }
                else
                {
                    $verifierDate = ($verifierDate AND true);
                }
            }
        }

        $itineraires = json_decode($request->itineraire, true);
       
        // Si l'itinéraire est inférieur a deux
        if (is_array($itineraires) === false || count($itineraires) < 2)
        {

            $res = [
                "value" => "Vous devez choisir au moins deux itinéraires" ,
                "status" => "error"
            ];

            return response()->json($res);    
        }

        // Si la date de depart est supérieur a la date d'arrivée
        if ($date_arrivee !== null AND $date_depart->greaterThan($date_arrivee))
        {
            
            $res = [
                "value" => "La date de depart doit être inférieur a la date d'arrivée" ,
                "status" => "error"
            ];

            return response()->json($res);            
        }

        // Verifier si la status est terminé et que la carburant restant n'est pas nulle
        $carburant_total = $request->etat === Trajet::getEtat(2) ? doubleval($camion->stockCarburant()) -  doubleval($request->carburantRestant) : null;
        $carburant_depart = ( $camion->stockCarburant() >= doubleval($request->carburantRestant) && doubleval($request->carburantRestant) > 0 )  ? doubleval($request->carburantRestant) : 0;
        
        if (($request->etat === Trajet::getEtat(1) || $request->etat === Trajet::getEtat(2)) AND $request->carburantRestant === null)
        {
            
            $res = [
                "value" => "Veuillez remplir la quantité de carburant restant" ,
                "status" => "error"
            ];

            return response()->json($res);                
        }
        
        else if($request->etat === Trajet::getEtat(1) && $carburant_depart == 0){

            $res = [
                "value" => "Le carburant du véhicule est encore insuffisant" ,
                "status" => "error"
            ];

            return response()->json($res);             }
        
        else if($request->etat === Trajet::getEtat(2)){

            if($carburant_total < 0 ){
                $res = [
                    "value" => "La quantité de carburant que vous avez saisi est superieur au stock actuel" ,
                        "status" => "error"
                ];

                return response()->json($res);                    
        }

            $CarburantSortie = doubleval($camion->CarburantRestant()) - doubleval($request->carburantRestant);

            

            if($CarburantSortie > 0){

                $carburant = Carburant::create([
                    "quantite" => $CarburantSortie,
                    "flux" => 1,
                    "date" => $date_arrivee,
                    "camion_id" => $camion->id
                ]);
            }

        }

        $depart = ucfirst($itineraires[0]['nom']);
        $arrivee = ucfirst(end($itineraires)['nom']);

        $trajet = new Trajet([

            'depart' => $depart,
            'date_heure_depart' => $date_depart->toDateTimeString(),
            'arrivee' => $arrivee,
            'date_heure_arrivee' => $date_arrivee,
            'etat' => $request->etat,
            'camion_id' => intval($request->camion_id),
            'chauffeur_id' => $request->chauffeur === null ? null : intval($request->chauffeur),
            'carburant_depart' => ( $request->etat == Trajet::getEtat(1) || $request->etat == Trajet::getEtat(2) ) ? $carburant_depart : null ,
            'carburant_total' => $carburant_total,
            'carburant_id' => isset($carburant->id) === true ? $carburant->id : null ,
            'poids' => doubleval($request->poids) > 0 ? doubleval($request->poids) : null,
            'chargement' => $request->chargement,
            'bon' => $request->bon,
            "bon_enlevement" => $request->bon_enlevement
        ]);

        if ($trajet->save())
        {
            /*$Carburant = Carburant::create([
                'quantite' =>
            ]);*/

            // Enregistrement des remorque utilisés

            foreach ($request->remorque as $key => $value) {
                # code...
                TrajetRemorque::create([
                    'remorque_id' => $value,
                    'trajet_id' => $trajet->id
                ]);
            }

            // Enregistrement de tous les itinéraires
            foreach ($itineraires as $itineraire)
            {
                $itineraire = Itineraire::create([
                    'nom' => $itineraire['nom'],
                    'id_trajet' => $trajet->id,
                ]);
            }

            $request->session()->flash("notification", [
                "value" => "Trajet ajouté" ,
                "status" => "success"
            ]);
           
            $res = [
                "value" => route("camion.voir", ["camion" => $request->camion_id, "tab" => 2]) ,
                "status" => "success"
            ];
        }
        else
        {
           
            $res = [
                "value" => "echec d'ajout" ,
                "status" => "error"
            ];
        }
        return response()->json($res);       
    }


    /**
    * Modifier un trajer
    *
    * @param Trajet $trajet Trajet a modifier
    * @return JsonResponse JSON contenant les ifons contenant le trajet
    */
    public function modifier(Trajet $trajet) : JsonResponse
    {
        
        $itineraires = $trajet->itineraires;
        return response()->json([
            "trajet" => $trajet,
            "itineraires" => $itineraires,
            "chauffeur" => $trajet->chauffeur,
            "reservation" => $trajet->reservation,
            "remorque" => TrajetRemorque::where("trajet_id", $trajet->id)->get("remorque_id")->toArray()
        ]);
    }


    /**
    * Mettre a jour un trajet
    *
    * @param Request $request Requete contenant tous les champs
    * @param Trajet $trajet Le trajet a mettre a jour
    * @return RedirectResponse
    */
    public function update(Request $request, Trajet $trajet) 
    {
        // Validation des données reçues
        $data = $request->validate([
            "camion_id" => ["required", "exists:camions,id"],
            "etat" => ['required', Rule::in(Trajet::getEtat())],
            "chauffeur" => ['nullable', 'exists:chauffeurs,id'],
            "date_heure_depart" => ['required', 'date'],
            "date_heure_arrivee" => ['required', 'date'],
            "itineraire" => ["required", "sometimes"],
            "carburantRestant" => ['nullable', 'numeric'] ,
            "poids" => ['nullable', 'numeric' , "min:0"],
            "chargement" => ["required", "min:3"],
            "bon" => ["required", "min:1"],
            "bon_enlevement" => [new BonEnlevement($request->etat)],
            "remorque" => ['required', new RemorqueRule()]

        ]);

        $res = [];

        $date_depart = Carbon::parse(date("Y-m-d H:i:s", strtotime($request->date_heure_depart)), 'EAT');
        $date_arrivee = $request->date_heure_arrivee === null ? null : Carbon::parse(date("Y-m-d H:i:s", strtotime($request->date_heure_arrivee)), 'EAT');


        $camion = Camion::findOrFail($request->camion_id);

        $carburant = collect();

        foreach ($request->remorque as $key => $value) {
            $remorque = Remorque::find($value);
 
            if($remorque->estDispoEntre($date_depart, $date_arrivee, $trajet) !== true){
    
                $res = [
                    "value" => "Remorque non disponible entre les dates que vous avez selectionnées" ,
                    "status" => "error"
                ];
    
                return response()->json($res);
            }
         }
        

        if($camion->estDispoEntre($date_depart, $date_arrivee, $trajet ) !== true){

            $res = [
                "value" => "Camion non disponible entre les dates que vous avez selectionnées" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        // Verifier si le trajet est affilié à une reservation tms mais que le transporteur à changer la date de depart
        if(isset($trajet->reservation->id) && strtotime($date_depart) != strtotime($trajet->reservation->date)  ){
           
            $res = [
                "value" => "La date de depart du trajet ne peut pas être modifié" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        if ($request->chauffeur !== null)
        {
            $chauffeur = Chauffeur::findOrFail($request->chauffeur);

            if ($chauffeur->estDispoEntre($date_depart, $date_arrivee, $trajet) === false AND $request->etat !== Trajet::getEtat(2))
            {
                
                $res = [
                    "value" => "Chauffeur non disponible entre les dates que vous avez selectionné" ,
                    "status" => "error"
                ];
    
                return response()->json($res);
            }
        }
        else
        {
            if ($request->etat !== Trajet::getEtat(0))
            {                 

                $res = [
                    "value" => "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" ,
                    "status" => "error"
                ];
    
                return response()->json($res);
            }
        }

        if ($trajet->etat === Trajet::getEtat(0) AND $request->etat === Trajet::getEtat(2))
        {
            
            $res = [
                "value" => "On ne peut pas terminer un trajet a prévoir sans être en cours" ,
                "status" => "error"
            ];

            return response()->json($res);
            //dd("Ne peut pas terminer un trajet a prévoir.");
        }

        // Pour demarrer le trajet, il faut que la date soit inferieur ou egal a la date heure en cours
        if ($request->etat === Trajet::getEtat(1) AND $date_depart->greaterThanOrEqualTo(Carbon::now()))
        {
            
            $res = [
                "value" => "La date depart ne doit pas depasser la date et heure actuel" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        if ($request->etat === Trajet::getEtat(2) AND $request->date_heure_arrivee === null)
        {
            
            $res = [
                "value" => "Vous devez specifier une date d'arrivée." ,
                "status" => "error"
            ];

            return response()->json($res);
            //dd('Vous devez specifier une date d\'arrivée');
        }


        // Verifications des dates des trajets

        $verifierDate = true;

        // Verifier l'etat en fonction de la trajet en cours: Si a un trajet en cours, l'état ne doit pas etre en cours aussi, ou terminé
        if ($camion->aUnTrajetEnCours($trajet) AND ($request->etat === Trajet::getEtat(1) OR $request->etat === Trajet::getEtat(2)))
        {
            $res = [
                "value" => "Le camion a encore un trajet en cours" ,
                "status" => "error"
            ];

            return response()->json($res);
        }

        foreach ($camion->trajets as $t)
        {
            if ($t->id !== $trajet->id)
            {
                $date_dpart_trajet = Carbon::parse($trajet->date_heure_depart, 'EAT');
                $date_arrivee_trajet = Carbon::parse($trajet->date_heure_arrivee, 'EAT');

                if ($date_dpart_trajet->greaterThan($date_depart))
                {
                    $verifierDate = ($verifierDate AND false);
                }
                else
                {
                    if ($date_arrivee_trajet !== null AND $date_arrivee_trajet->greaterThan($date_depart))
                    {
                        $verifierDate = ($verifierDate AND false);
                    }
                    else
                    {
                        $verifierDate = ($verifierDate AND true);
                    }
                }
            }
        }

        
        $itineraires = json_decode($data['itineraire'], true);
        
        // Si l'itinéraire est inférieur a deux
        if (is_array($itineraires) === false || count($itineraires) < 2)
        {
            $res = [
                "value" => "Vous devez choisir au moins deux itinéraires" ,
                "status" => "error"
            ];

            return response()->json($res);   
        }

        // Si la date de depart est supérieur a la date d'arrivée
        if ($date_arrivee !== null AND $date_depart->greaterThan($date_arrivee))
        {
            
            $res = [
                "value" => "La date de depart doit être inférieur a la date d'arrivée" ,
                "status" => "error"
            ];

            return response()->json($res);            
        }

        
        $depart = $itineraires[0]['nom'];
        $arrivee = end($itineraires)['nom'];
        $etat = $request->etat;

        // Verifier si la status est terminé et que la carburant restant n'est pas nulle
        $carburant_total = $request->etat === Trajet::getEtat(2) ? (doubleval($camion->stockCarburant()) + doubleval($trajet->carburant_total) ) -  doubleval($request->carburantRestant) : null;
        $carburant_depart = $camion->stockCarburant() >= doubleval($request->carburantRestant) ? doubleval($request->carburantRestant) : 0;

        
             

        if (($request->etat === Trajet::getEtat(1) || $request->etat === Trajet::getEtat(2) ) AND $request->carburantRestant === null)
        {
            
            $res = [
                "value" => "Veuillez remplir la quantité de carburant restant" ,
                "status" => "error"
            ];

            return response()->json($res);
            
        }
        
        else if($request->etat === Trajet::getEtat(1) && $carburant_depart == 0){
            
            $res = [
                "value" => "Le carburant du véhicule est encore insuffisant" ,
                "status" => "error"
            ];

            return response()->json($res);
        }
        
        else if($request->etat === Trajet::getEtat(2)){

          
           
            if($carburant_total < 0 ) {
                               
                $res = [
                    "value" => "La quantité de carburant que vous avez saisi est superieur au stock" ,
                    "status" => "error"
                ];
    
                return response()->json($res);
            }

            Carburant::where("id", $trajet->carburant_id)->delete();
            $CarburantSortie = doubleval($camion->CarburantRestant()) - doubleval($request->carburantRestant);
            
            if($CarburantSortie > 0 || $trajet->carburant_id != null ){
                
                $carburant = Carburant::create([
                    "quantite" => $CarburantSortie,
                    "flux" => 1,
                    "date" => $date_arrivee,
                    "camion_id" => $camion->id
                ]);
            }
        }

 
        $_trajet = [
            'depart' => $depart,
            'date_heure_depart' => $date_depart->toDateTimeString(),
            'arrivee' => $arrivee,
            'date_heure_arrivee' => $date_arrivee,
            'etat' => $etat,
            'chauffeur_id' => $request->chauffeur === null ? null : intval($request->chauffeur),
            'carburant_id' => isset($carburant->id) === true ? $carburant->id : null,
            'poids' => doubleval($request->poids) > 0 ? doubleval($request->poids) : null,
            'chargement' => $request->chargement ,
            'bon' => $request->bon,
            'bon_enlevement' => $request->bon_enlevement,

        ];

        if($request->etat === Trajet::getEtat(1)){
            $_trajet["carburant_depart"] = $carburant_depart;
        }

        if($request->etat === Trajet::getEtat(2)){
             // Recalculer le carburant total
            

            $_trajet["carburant_total"] = $carburant_total;
        }
        
        $update = $trajet->update($_trajet);

        if ($update)
        {
            TrajetRemorque::where("trajet_id", $trajet->id)->delete();

            foreach ($request->remorque as $key => $value) {
                # code...

                TrajetRemorque::create([
                    "trajet_id" => $trajet->id,
                    "remorque_id" => $value
                ]);
            }

            if( isset($trajet->reservation->id) === true ){

                if($trajet->etat == Trajet::getEtat(2)){
                    $trajet->reservation->status = Reservation::STATUS[2];
                    $trajet->reservation->update();
                }
    
                if($trajet->etat == Trajet::getEtat(3)){
                    $trajet->reservation->status = Reservation::STATUS[6];
                    $trajet->reservation->update();
                }
            }


            //Supprimer les itineraire existant
            $trajet->viderTrajet();
            
            foreach ($itineraires as $itineraire)
            {
                $itineraire = Itineraire::create([
                    'nom' => $itineraire['nom'],
                    'id_trajet' => $trajet->id,
                ]);
            }

            $request->session()->flash("notification", [
                "value" => "Mise a jour avec success." ,
                "status" => "success"
            ]);

           $res = [
                "value" => route("camion.voir", ["camion" => $request->camion_id, "tab" => 2]) ,
                "status" => "success"
            ];
        }
        else
        {
            
            $res = [
                "value" => "Erreur de mise a jour" ,
                "status" => "error"
            ];

        }
        
        return response()->json($res);

    }

    /**
    * Methode permettant de supprimer un trajet
    *
    * @param Trajet $trajet
    * @return RedirectResponse Redirection vers la page precedente
    */
    public function supprimer(Request $request, Trajet $trajet) : RedirectResponse
    {

        $trajet->remorques()->delete();
        $trajet->itineraires()->delete();
        if($trajet->carburant_id !== null){
            $trajet->carburant->delete();
        }
        $delete = $trajet->delete();

        if ($delete)
        {
            $request->session()->flash("notification", [
                "value" => "Trajet supprimé" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Impossible de supprimer le trajet" ,
                "status" => "error"
            ]);
        }

        return redirect()->route('camion.voir', ['camion' => $trajet->camion_id, 'tab' => 2]);

    }
}
