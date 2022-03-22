<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Papier extends Model
{
    use HasFactory;

    CONST TYPE = [ "Assurance", "Visite technique"];

    protected $fillable = ["designation", "type", "date", "date_echeance", "camion_id", "photo"];

    public static function EnCours($type){

        $sql = "SELECT * FROM papiers as pap WHERE pap.type = '".$type."' AND pap.date_echeance = ( SELECT MAX(papiers.date_echeance) FROM papiers WHERE papiers.type = '".$type."') ";

        $papier = collect(DB::select($sql));

        return $papier;
        
    }
}
