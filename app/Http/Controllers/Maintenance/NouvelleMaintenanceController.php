<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Maintenance\Maintenance;
use App\Http\Requests\Maintenance\NouvelleMaintenanceRequest;
use App\Models\Fournisseur;
use App\Models\MaintenancePieceFrs;
use App\Models\Piece;

class NouvelleMaintenanceController extends Controller
{
    /**
     * Enregistrer une nouvelle maintenanca
     *
     * @param NouvelleMaintenanceRequest $request Requete contenant tous les champs de la formulaire
     * @return JsonResponse|RedirectResponse
     */
    public function store(NouvelleMaintenanceRequest $request)
    {
        $data = $request->validated();
        $pieces = json_decode($data['pieces'], true);

        $maintenance = Maintenance::create($data);

        foreach ($pieces as $key => $value)
        {
            $piece = Piece::where('designation', $key)->first();
            $fournisseur = Fournisseur::where('nom', $value['frs'])->first();

            if ($piece === null) $piece = Piece::create(["designation" => $key]);

            if ($fournisseur === null)
            {
                $fournisseur = Fournisseur::create(["nom" => $value["frs"], "contact" => $value['contactFrs']]);
            }
            else
            {
                $fournisseur->contact = $value["contactFrs"];
                $fournisseur->update();
            }

            MaintenancePieceFrs::create([
                "piece" => $piece->id,
                "maintenance" => $maintenance->id,
                "fournisseur" => $fournisseur->id,
                "pu" => $value["pu"],
                "quantite" => $value["quantite"],
                "total" => $value["total"],
            ]);
        }

        if ($maintenance)
            $request->session()->flash("notification", [
                "value" => "Maintenance enregistré avec success" ,
                "status" => "success"
            ]);
        else
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite pendant l'enregistremet" ,
                "status" => "error"
            ]);

        if ($request->ajax()) return response()->json(['redirect' => route('maintenance.index')]);
        return redirect()->back();
    }
}
