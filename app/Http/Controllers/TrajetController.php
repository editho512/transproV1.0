<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Itineraire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class TrajetController extends Controller
{
    public function add(Request $request) : RedirectResponse
    {
        $request->validate([
            "camion_id" => ['required', 'numeric', 'exists:camions,id'],
            "chauffeur" => ['required', 'exists:chauffeurs,id'],
            "date_heure_depart" => ['required', 'date'],
            "date_heure_arrivee" => ['required', 'date'],
            "numero" => ['nullable', 'numeric', 'min:1', 'max:999999999'],
        ]);

        $itineraires = json_decode($request->itineraire, true);

        // Si l'itinéraire est inférieur a deux
        if (count($itineraires) < 2) return back()->withErrors('Veillez choisir au moins deux itinéraires', 'error');

        $date_depart = Carbon::parse($request->date_heure_debut);
        $date_arrivee = Carbon::parse($request->date_heure_arrivee);

        // Si la date de depart est supérieur a la date d'arrivée
        if ($date_depart->greaterThan($date_arrivee)) return back()->withErrors('La date de depart doit etrer inférieur a la date d\'arrivée');

        $etat = 'En cours';

        // Si la d'ate de départ est superieur a la date et heure actuel, l'etat sera a prévoir
        if ($date_depart->greaterThan(Carbon::now())) $etat = "A prévoir";

        $depart = ucfirst($itineraires[0]['nom_itineraire']);
        $arrivee = ucfirst(end($itineraires)['nom_itineraire']);

        $trajet = new Trajet([
            'depart' => $depart,
            'date_heure_depart' => $date_depart->toDateTimeString(),
            'arrivee' => $arrivee,
            'date_heure_arrivee' => $date_arrivee->toDateTimeString(),
            'etat' => $etat,
            'camion_id' => intval($request->camion_id),
            'chauffeur_id' => intval($request->chauffeur),
        ]);

        if ($trajet->save())
        {
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

    public function modifier(Trajet $carburant){
        return response()->json($carburant);
    }

    public function update(Request $request, Trajet $carburant){
        $data = $request->except("_token");

        if(isset($data['quantite']) && intval($data['quantite']) >= 0 && isset($data['date']) && isset($data['flux']) ){
            $data["date"] = date("Y-m-d", strtotime($data["date"]));

            $carburant->date = $data["date"];
            $carburant->quantite = $data["quantite"];
            $carburant->flux = $data["flux"];
            $carburant->camion_id = $data["camion_id"];
            $carburant->update();
            Session::put("notification", [
                "value" => "Carburant modifié" ,
                "status" => "success"
            ]);
        }else{
            Session::put("notification", [
                "value" => "echec d'ajout" ,
                "status" => "error"
            ]);
        }
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
