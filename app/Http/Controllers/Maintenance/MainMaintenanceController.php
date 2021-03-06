<?php

namespace App\Http\Controllers\Maintenance;

use App\Models\Piece;
use App\Models\Camion;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Maintenance\Maintenance;
use App\Models\MaintenancePieceFrs;

class MainMaintenanceController extends Controller
{
    /**
     * Page d'accueil de la maintenance
     *
     * @return View
     */
    public function index() : View
    {
        return $this->liste();
    }


    /**
     * Listes de tous les maintenances
     *
     * @return View
     */
    public function liste() : View
    {
        $maintenances = Maintenance::all();
        $active_maintenance_index = "active";
        $maintenancesGroups = $maintenances->groupBy(function($data) {
            return $data->type;
        });

        $pieces = Piece::all();
        $fournisseurs = Fournisseur::all();

        return view('maintenance.liste', [
            'maintenances' => $maintenances,
            'camions' => Camion::all(),
            'active_maintenance_index' => $active_maintenance_index,
            'maintenancesGroups' => $maintenancesGroups,
            'pieces' => $pieces,
            'fournisseurs' => $fournisseurs,
        ]);
    }


    /**
     * Permet de supprimer une maintenance
     *
     * @param Maintenance $maintenance
     * @return RedirectResponse
     */
    public function supprimer(Request $request, Maintenance $maintenance) : RedirectResponse
    {
        MaintenancePieceFrs::where("maintenance", $maintenance->id)->delete();
        
        if ($maintenance->delete())
            $request->session()->flash("notification", [
                "value" => "Maintenance supprimé avec success" ,
                "status" => "success"
            ]);
        else
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite lors de la suppresion" ,
                "status" => "error"
            ]);

        return redirect()->back();
    }

    public function voir(Maintenance $maintenance)
    {
        return response()->json($maintenance);
    }
}
