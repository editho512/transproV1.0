<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Carburant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class CarburantController extends Controller
{
    /**
    * Ajouter un nouveau flux de carburant
    *
    * @param Request $request Requete contenant tous les champs
    * @return RedirectResponse
    */
    public function add(Request $request) : RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            "camion_id" => ['required', 'numeric', 'exists:camions,id'],
            "date" => ['required', 'date'],
            "quantite" => ['required', 'numeric', 'min:0'],
            "flux" => ['required', 'numeric', 'min:0', 'max:0'],
            "prix" => ['required', 'numeric', 'min:0']
        ]);

        if ($validator->fails()) {
            $request->session()->flash("notification", [
                "value" => "Echec d'ajout de carburant" ,
                "status" => "error"
            ]);
            return redirect()->back();
        }

        if (!$validator->fails()) {

            $data = $request->all();

            $data['date'] = Carbon::parse($data['date'])->toDateTimeString();
            $carburant = new Carburant($data);

            try
            {
                if ($carburant->save())
                {
                    $request->session()->flash("notification", [
                        "value" => "Carburant ajouté" ,
                        "status" => "success"
                    ]);
                }
                else
                {
                    $request->session()->flash("notification", [
                        "value" => "Une erreur est survenu lors de l'ajout du carburant" ,
                        "status" => "error"
                    ]);
                }
            }
            catch (QueryException $e)
            {
                dd("Une erreur est survenu, contactez l'administrateur. Message d'erreur : " , $e->getMessage());
            }
            return redirect()->route('camion.voir', ['camion' => $data['camion_id'], 'tab' => 1]);
        }

    }

    public function modifier(Carburant $carburant)
    {
        return response()->json($carburant);
    }

    public function update(Request $request, Carburant $carburant)
    {
        $validator = Validator::make($request->all(), [
            "date" => ['required', 'date'],
            "quantite" => ['required', 'numeric', 'min:0'],
            "flux" => ['required', 'numeric', 'min:0', 'max:0'],
            "prix" => ['required', 'numeric', 'min:0']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash("notification", [
                "value" => "Echec de modification de carburant" ,
                "status" => "error"
            ]);
            return redirect()->back();
        }

        if (!$validator->fails())
        {
            $data = $request->except("_token");

            if(isset($data['quantite']) && intval($data['quantite']) >= 0 && isset($data['date']) && isset($data['flux']) )
            {
                $data["date"] = date("Y-m-d", strtotime($data["date"]));

                $carburant->date = $data["date"];
                $carburant->quantite = $data["quantite"];
                $carburant->prix = $data["prix"];
                $carburant->flux = $data["flux"];
                $carburant->camion_id = $data["camion_id"];
                $carburant->update();
                $request->session()->put("notification", [
                    "value" => "Carburant modifié" ,
                    "status" => "success"
                ]);
            }
            else
            {
                $request->session()->put("notification", [
                    "value" => "echec d'ajout" ,
                    "status" => "error"
                ]);
            }
            return redirect()->route('camion.voir', ['camion' => $carburant->camion_id, 'tab' => 1]);
        }
    }

    public function delete(Carburant $carburant)
    {
        $carburant->delete();
        request()->session()->put("notification", [
            "value" => "Carburant supprimé" ,
            "status" => "success"
        ]);
        return redirect()->route('camion.voir', ['camion' => $carburant->camion_id, 'tab' => 1]);

    }
}
