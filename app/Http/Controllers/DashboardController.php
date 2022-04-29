<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Depense\Depense;
use App\Models\Maintenance\Maintenance;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index(){
        $active_dashboard_index = true;
        $carburants = Carburant::consomation();
        
        $depense = Depense::depensePerDriver();

        $depenseCamion = Depense::depensePerCamion();
        
        $maintenance = Maintenance::dashboard();

        return view("dashboard.dashboard", compact("active_dashboard_index", "carburants", "depense", "depenseCamion", "maintenance"));
    }

    public function maintenance(Request $request){
        $data = $request->all();

        $debut = isset($data["debut"]) ? date("Y-m-d", strtotime($data["debut"])) : null ;
        $fin = isset($data["fin"]) ? date("Y-m-d", strtotime($data["fin"])) : null ;
        
        $maintenance = Maintenance::dashboard($debut, $fin);

        return response()->json($maintenance);

    }

    public function carburant($mois){
            $mois = intval($mois) >= 0 ? intval($mois) : 0 ;
            $date = date("Y-m-d", strtotime("-". intval($mois) ." month", strtotime(date("d-m-Y"))));

            $carburants = Carburant::consomation($date);

            return response()->json($carburants);      

    }

    public function depensePerDriver(Request $request){
        $data = $request->all();

        $debut = isset($data["debut"]) ? date("Y-m-d", strtotime($data["debut"])) : null ;
        $fin = isset($data["fin"]) ? date("Y-m-d", strtotime($data["fin"])) : null ;
        $type = isset($data["type"]) ? $data["type"] : null;

        $depense = Depense::depensePerDriver($debut, $fin, $type);

        return response()->json($depense);

    }

    public function depensePerCamion(Request $request){
        $data = $request->all();

        $debut = isset($data["debut"]) ? date("Y-m-d", strtotime($data["debut"])) : null ;
        $fin = isset($data["fin"]) ? date("Y-m-d", strtotime($data["fin"])) : null ;
        $type = isset($data["type"]) ? $data["type"] : null;

        $depense = Depense::depensePerCamion($debut, $fin, $type);

        return response()->json($depense);
    }
    
}
