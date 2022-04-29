<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maintenance\NouvelleMaintenanceRequest;
use App\Models\Maintenance\Maintenance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
        $maintenance = Maintenance::create($data);

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
