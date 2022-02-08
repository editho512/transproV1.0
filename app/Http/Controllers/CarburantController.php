<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Carburant;
use Illuminate\Http\Request;

class CarburantController extends Controller
{
    //
    public function add(Request $request){

        $data = $request->except("_token");
        if(isset($data['quantite']) && intval($data['quantite']) >= 0 && isset($data['date']) && isset($data['flux']) ){
            $data["date"] = date("Y-m-d", strtotime($data["date"]));
            
            Carburant::create($data);
            Session::put("notification", ["value" => "Carburant ajouté" ,
                        "status" => "success"
            ]);
        }else{
            Session::put("notification", ["value" => "echec d'ajout" ,
                        "status" => "error"
            ]);
        }
        return redirect()->back();
    }

    public function modifier(Carburant $carburant){
        return response()->json($carburant);
    }

    public function update(Request $request, Carburant $carburant){
        $data = $request->except("_token");

        if(isset($data['quantite']) && intval($data['quantite']) >= 0 && isset($data['date']) && isset($data['flux']) ){
            $data["date"] = date("Y-m-d", strtotime($data["date"]));

            $carburant->date = $data["date"];
            $carburant->quantite = $data["quantite"];
            $carburant->flux = $data["flux"];
            $carburant->camion_id = $data["camion_id"];
            $carburant->update();
            Session::put("notification", ["value" => "Carburant modifié" ,
                        "status" => "success"
            ]);
        }else{
            Session::put("notification", ["value" => "echec d'ajout" ,
                        "status" => "error"
            ]);
        }
        return redirect()->back();

    }

    public function delete(Carburant $carburant){
        $carburant->delete();
        Session::put("notification", ["value" => "Carburant supprimé" ,
                    "status" => "success"
            ]);
        return redirect()->back();

    }
}
