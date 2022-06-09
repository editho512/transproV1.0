<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PieceController extends Controller
{

    /**
     * Recuperer un pièce
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(Piece::where('designation', $request->name)->firstOrFail());
    }

}
