<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maintenance\NouvelleMaintenanceRequest;
use App\Models\Maintenance\Maintenance;

class NouvelleMaintenanceController extends Controller
{
    public function store(NouvelleMaintenanceRequest $request)
    {
        $data = $request->validated();

        $maintenance = Maintenance::create($data);

        if ($maintenance)
        {
            $request->session()->flash("notification", [
                "value" => "Maintenance enregistré avec success" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite pendant l'enregistremet" ,
                "status" => "error"
            ]);
        }

        if ($request->ajax())
        {
            return response()->json(['redirect' => route('maintenance.index')]);
        }
        return redirect()->back();
    }
}
