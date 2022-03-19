<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\Maintenance;
use App\Http\Requests\Maintenance\ModifierMaintenanceRequest;

class ModifierMaintenanceController extends Controller
{
    public function create(Maintenance $maintenance) : JsonResponse
    {
        return response()->json($maintenance);
    }


    public function store(ModifierMaintenanceRequest $request, Maintenance $maintenance)
    {
        $data = $request->validated();
        $update = $maintenance->update($data);

        if ($update)
        {
            $request->session()->flash("notification", [
                "value" => "Maintenance mis a jour avec success" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite lors de la mise a jour" ,
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
