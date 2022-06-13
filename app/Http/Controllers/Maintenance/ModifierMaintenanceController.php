<?php

namespace App\Http\Controllers\Maintenance;

use App\Models\Piece;
use App\Models\Fournisseur;
use Illuminate\Http\JsonResponse;
use App\Models\MaintenancePieceFrs;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Maintenance\Maintenance;
use App\Http\Requests\Maintenance\ModifierMaintenanceRequest;

class ModifierMaintenanceController extends Controller
{
    /**
     * Retourne la maintenance a modifier sous forme JSON
     *
     * @param Maintenance $maintenance Maintenance type eloquent
     * @return JsonResponse Maintenance sous forme JSON
     */
    public function create(Maintenance $maintenance) : JsonResponse
    {
        return response()->json($maintenance);
    }

    /**
     * Permet d'enregistrer une maintenance
     *
     * @param ModifierMaintenanceRequest $request Requete contenant tous les champs de la formulaire
     * @param Maintenance $maintenance Maintenance a mettre a jour
     * @return RedirectResponse|JsonResponse
     */
    public function store(ModifierMaintenanceRequest $request, Maintenance $maintenance)
    {
        $data = $request->validated();
        $update = $maintenance->update($data);

        $pieces = json_decode($data['pieces'], true);

        foreach (MaintenancePieceFrs::all() as $d)
        {
            if (!in_array(Piece::find($d->piece)->designation, collect($pieces)->pluck('nom')->toArray()))
            {
                $d->delete();
            }
        }


        foreach ($pieces as $key => $value) {
            $piece = Piece::where('designation', $key)->first();
            $fournisseur = Fournisseur::where('nom', $value['frs'])->first();

            if ($piece === null) $piece = Piece::create(["designation" => $key]);

            if ($fournisseur === null) {
                $fournisseur = Fournisseur::create(["nom" => $value["frs"], "contact" => $value['contactFrs']]);
            } else {
                $fournisseur->contact = $value["contactFrs"];
                $fournisseur->update();
            }

            $maintenancePieceFrs = MaintenancePieceFrs::where("piece", $piece->id)->where("maintenance", $maintenance->id)->where("fournisseur", $fournisseur->id)->first();

            if ($maintenancePieceFrs !== null)
            {
                $maintenancePieceFrs->pu = $value["pu"];
                $maintenancePieceFrs->quantite = $value["quantite"];
                $maintenancePieceFrs->total = $value["total"];
                $maintenancePieceFrs->save();
            }
            else
            {
                MaintenancePieceFrs::create([
                    "piece" => $piece->id,
                    "maintenance" => $maintenance->id,
                    "fournisseur" => $fournisseur->id,
                    "pu" => $value["pu"],
                    "quantite" => $value["quantite"],
                    "total" => $value["total"],
                ]);
            }

        }

        if ($update)
            $request->session()->flash("notification", [
                "value" => "Maintenance mis a jour avec success" ,
                "status" => "success"
            ]);
        else
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite lors de la mise a jour" ,
                "status" => "error"
            ]);

        if ($request->ajax()) return response()->json(['redirect' => route('maintenance.index')]);
        return redirect()->back();
    }
}
