<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carburant extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'prix',
        'flux',
        'date',
        'camion_id'
    ];

    public static function consomation($date = null){
        $date = $date == null ? date("d-m-Y") : date("d-m-Y", strtotime($date));
        
        $req = self::join("camions", "camions.id", "carburants.camion_id")
                    ->where("carburants.flux", 1)
                    ->whereYear('carburants.created_at', '=', date("Y", strtotime($date)))
                    ->whereMonth('carburants.created_at', '=', date("m", strtotime($date)))
                    ->groupBy("camions.id")
                    ->selectRaw('sum(carburants.quantite) as quantite, camions.name');
       
        return $req->get();
    }
    
}
