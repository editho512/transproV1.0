<?php

namespace App\Http\Controllers\Localisation;

use App\Http\Controllers\Controller;
use App\Models\Camion;
use Illuminate\Http\Request;

class MainLocalisationController extends Controller
{
    public function index()
    {
        $camions = Camion::all();

        return view('localisation.index', [
            'active_localisation_index' => 'active',
            'camions' => $camions,
        ]);
    }
}
