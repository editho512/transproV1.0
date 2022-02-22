<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrajetController extends Controller
{
    public function add(Request $request) : RedirectResponse
    {

        dd($request->all());

        $data = $request->validate([
            "camion_id" => ['required', 'numeric', 'exists:camions,id'],
            "chauffeur" => ['required', 'exists:chauffeur,id'],
            "camion" => ['required', 'numeric', 'exists:camions,id'],
            "date_heure_depart" => ['required', 'date'],
            "date_heure_arrivee" => ['required', 'date'],
            "numero" => ['nullable', 'numeric', 'min:1', 'max:999999999'],
        ]);

        if (Trajet::create($data))
        {
            Session::put("notification", [
                "value" => "Carburant ajouté" ,
                "status" => "success"
            ]);
        }
        else
        {
            Session::put("notification", [
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
