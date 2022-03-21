<?php

namespace App\Http\Controllers\Depense;

use App\Models\Camion;
use App\Models\Chauffeur;
use Illuminate\Http\Request;
use App\Models\Depense\Depense;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class MainDepenseController extends Controller
{
    /**
     * Page d'accueil de la dépense
     * En générale contient toute la liste des depenses
     *
     * @return View
     */
    public function index() : View
    {
        return $this->liste();
    }


    /**
     * Methode qui affiche tous les lestes de dépenses
     *
     * @return View
     */
    public function liste() : View
    {
        $depenses = Depense::all();
        $active_depense_index = "active";
        $depensesGroups = Depense::all()->groupBy(function($data) {
            return $data->type;
        });

        return view('depense.liste', [
            'depenses' => $depenses,
            'camions' => Camion::all(),
            'chauffeurs' => Chauffeur::all(),
            'active_depense_index' => $active_depense_index,
            'depensesGroups' => $depensesGroups,
        ]);
    }


    /**
     * Permet de supprimer un dépense
     *
     * @param Depense $depense
     * @return RedirectResponse
     */
    public function supprimer(Request $request, Depense $depense) : RedirectResponse
    {
        if ($depense->delete())
        {
            $request->session()->flash("notification", [
                "value" => "Dépense supprimé avec success" ,
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


    public function voir(Depense $depense)
    {
        return response()->json($depense);
    }
}
