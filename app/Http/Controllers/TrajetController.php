<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\Trajet;
use App\Models\Itineraire;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TrajetController extends Controller
{
    /**
     * Methode qui ajoute un nouveau trajet dans la base de données
     *
     * @param Request $request Contenant tous les champs
     * @return RedirectResponse Redirection vers la page precedente
     */
    public function add(Request $request) : RedirectResponse
    {
        // Validation des données reçues
        $request->validate([
            "camion_id" => ['required', 'numeric', 'exists:camions,id'],
            "etat" => ['required', Rule::in(Trajet::getEtat())],
            "chauffeur" => ['required', 'exists:chauffeurs,id'],
            "date_heure_depart" => ['required', 'date'],
            "date_heure_arrivee" => ['nullable', 'date'],
        ]);

        $date_depart = Carbon::parse($request->date_heure_depart, 'EAT');
        $date_arrivee = $request->date_heure_arrivee === null ? null : Carbon::parse($request->date_heure_arrivee, 'EAT');

        // Verifier si le camion a un trajet en cours ou non
        $camion = Camion::findOrFail($request->camion_id);

        // Verifier l'etat en fonction de la trajet en cours: Si a un trajet en cours, l'état ne doit pas etre en cours aussi, ou terminé
        if ($camion->aUnTrajetEnCours() AND ($request->etat === Trajet::getEtat(1) OR $request->etat === Trajet::getEtat(2)))
        {
            $request->session()->flash("notification", [
                "value" => "Vous devez choisir l\'état a prévoir pour ce trajet" ,
                "status" => "success"
            ]);
            return redirect()->back();
        }

        if (Carbon::now('EAT')->greaterThanOrEqualTo($date_depart) AND $request->etat === Trajet::getEtat(0))
        {
            $request->session()->flash("notification", [
                "value" => "La date de depart doit être spérieur a ce moment précis si la status est aprévoir" ,
                "status" => "success"
            ]);

            return redirect()->back();
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
        if (count($itineraires) < 2)
        {
            $request->session()->flash("notification", [
                "value" => "Vous devez choisir au moins deux itinéraires" ,
                "status" => "error"
            ]);

            return redirect()->back();
        }

        // Si la date de depart est supérieur a la date d'arrivée
        if ($date_arrivee !== null AND $date_depart->greaterThan($date_arrivee))
        {
            dd('La date de depart doit etrer inférieur a la date d\'arrivée');
            return back()->withErrors('La date de depart doit etrer inférieur a la date d\'arrivée');
        }

        $etat = 'En cours';

        // Si la d'ate de départ est superieur a la date et heure actuel, l'etat sera a prévoir
        if ($date_depart->greaterThan(Carbon::now('EAT'))) $etat = "A prévoir";

        $depart = ucfirst($itineraires[0]['nom_itineraire']);
        $arrivee = ucfirst(end($itineraires)['nom_itineraire']);

        $trajet = new Trajet([
            'depart' => $depart,
            'date_heure_depart' => $date_depart->toDateTimeString(),
            'arrivee' => $arrivee,
            'date_heure_arrivee' => $date_arrivee,
            'etat' => $etat,
            'camion_id' => intval($request->camion_id),
            'chauffeur_id' => intval($request->chauffeur),
        ]);

        if ($trajet->save())
        {
            // Enregistrement de tous les itinéraires
            foreach ($itineraires as $itineraire)
            {
                $itineraire = Itineraire::create([
                    'nom' => $itineraire['nom_itineraire'],
                    'id_trajet' => $trajet->id,
                ]);
            }

            $request->session()->flash("notification", [
                "value" => "Trajet ajouté" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "echec d'ajout" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
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
        ]);
    }


    /**
     * Mettre a jour un trajet
     *
     * @param Request $request Requete contenant tous les champs
     * @param Trajet $trajet Le trajet a mettre a jour
     * @return RedirectResponse
     */
    public function update(Request $request, Trajet $trajet) : RedirectResponse
    {
        // Validation des données reçues
        $data = $request->validate([
            "etat" => ['required', Rule::in(Trajet::getEtat())],
            "chauffeur" => ['required', 'exists:chauffeurs,id'],
            "date_heure_depart" => ['required', 'date'],
            "date_heure_arrivee" => ['nullable', 'date'],
            "itineraire" => ["required", "sometimes"]
        ]);

        if ($trajet->etat === Trajet::getEtat(0) AND $request->etat === Trajet::getEtat(2))
        {
            $request->session()->flash("notification", [
                "value" => "Ne peus pas terminer un trajet a prévoir." ,
                "status" => "error"
            ]);

            return redirect()->back();
            //dd("Ne peut pas terminer un trajet a prévoir.");
        }

        if ($request->etat === Trajet::getEtat(2) AND $request->date_heure_arrivee === null)
        {
            $request->session()->flash("notification", [
                "value" => "Vous devez specifier une date d\'arrivée." ,
                "status" => "error"
            ]);

            return redirect()->back();
            //dd('Vous devez specifier une date d\'arrivée');
        }

        $itineraires = json_decode($data['itineraire'], true);

        $date_depart = Carbon::parse($request->date_heure_depart, 'EAT');
        $date_arrivee = $request->date_heure_arrivee === null ? null : Carbon::parse($request->date_heure_arrivee, 'EAT');
        $depart = $itineraires[0]['nom'];
        $arrivee = end($itineraires)['nom'];
        $etat = $request->etat;

        $update = $trajet->update([
            'depart' => $depart,
            'date_heure_depart' => $date_depart->toDateTimeString(),
            'arrivee' => $arrivee,
            'date_heure_arrivee' => $date_arrivee,
            'etat' => $etat,
            'chauffeur_id' => intval($request->chauffeur),
        ]);

        if ($update) $request->session()->flash('success', 'Trajet mis a jour avec success');
        else $request->session()->flash('error', 'Erreur de mise a jour');

        return redirect()->back();

    }

    public function delete(Trajet $carburant){
        $carburant->delete();
        Session::put("notification", [
            "value" => "Carburant supprimé" ,
            "status" => "success"
        ]);
        return redirect()->back();

    }
}
