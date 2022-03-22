<?php

namespace App\Http\Controllers\Depense;

use App\Models\Depense\Depense;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Depense\ModifierDepenseRequest;

class ModifierDepenseController extends Controller
{
    /**
     * Permet de crreer la vue contenant la depense a modifier
     *
     * @param Depense $depense
     * @return JsonResponse Dépense au format JSON a modifier
     */
    public function create(Depense $depense) : JsonResponse
    {
        return response()->json($depense);
    }


    /**
     * Enregistrer la modification d'une nouvelle dépense
     *
     * @param ModifierDepenseRequest $request Requere contenant tous les champs de la formulaire de modification
     * @return RedirectResponse|JsonResponse
     */
    public function store(Depense $depense, ModifierDepenseRequest $request)
    {
        $data = $request->validated();
        $update = $depense->update($data);

        if ($update)
            $request->session()->flash("notification", [
                "value" => "Dépense mis a jour avec success" ,
                "status" => "success"
            ]);
        else
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite lors de la mise a jour" ,
                "status" => "error"
            ]);

        if ($request->ajax()) return response()->json(['redirect' => route('depense.index')]);
        return redirect()->back();
    }
}
