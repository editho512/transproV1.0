<?php

namespace App\Http\Controllers\Maintenance;

use App\Models\Camion;
use Illuminate\Http\Request;
use App\Models\Depense\Depense;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Maintenance\Maintenance;

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
        $maintenancesGroups = Maintenance::all()->groupBy(function($data) {
            return $data->type;
        });

        return view('maintenance.liste', [
            'maintenances' => $maintenances,
            'camions' => Camion::all(),
            'active_maintenance_index' => $active_maintenance_index,
            'maintenancesGroups' => $maintenancesGroups,
        ]);
    }


        /**
     * Permet de supprimer un dépense
     *
     * @param Maintenance $maintenance
     * @return RedirectResponse
     */
    public function supprimer(Request $request, Maintenance $maintenance) : RedirectResponse
    {
        if ($maintenance->delete())
        {
            $request->session()->flash("notification", [
                "value" => "Maintenance supprimé avec success" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite lors de la suppresion" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
    }
}
