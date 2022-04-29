<?php

namespace App\Http\Controllers\Depense;

use App\Models\Depense\Depense;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Depense\NouvelleDepenseRequest;

class NouvelleDepenseController extends Controller
{
    /**
     * Enregistrer une nouvelle dépense
     *
     * @param NouvelleDepenseRequest $request Réquet contenant tous les champs de la formulaire
     * @return RedirectResponse|JsonResponse
     */
    public function store(NouvelleDepenseRequest $request)
    {
        $data = $request->validated();
        $depense = Depense::create($data);

        if ($depense)
            $request->session()->flash("notification", [
                "value" => "Dépense enregistré avec success" ,
                "status" => "success"
            ]);
        else
            $request->session()->flash("notification", [
                "value" => "Une erreur s'est produite pendant l'enregistremet" ,
                "status" => "error"
            ]);

        if ($request->ajax()) return response()->json(['redirect' => route('depense.index')]);
        return redirect()->back();
    }
}
