<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Fournisseur;

class FournisseurController extends Controller
{
    /**
     * Recuperer un fournisseur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(Fournisseur::where('nom', $request->name)->firstOrFail());
    }
}
