<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\Maintenance;
use App\Http\Requests\Maintenance\ModifierMaintenanceRequest;
use Illuminate\Http\RedirectResponse;

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
