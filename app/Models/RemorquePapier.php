<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RemorquePapier extends Model
{
    use HasFactory;

    protected $fillable = ['remorque_id', 'designation', 'type', 'date', 'date_echeance', 'photo'];

    public static function EnCours($type, $remorque_id){

        $sql = "SELECT * FROM remorque_papiers as pap WHERE pap.type = '".$type."' AND pap.date_echeance = ( SELECT MAX(remorque_papiers.date_echeance) FROM remorque_papiers WHERE remorque_papiers.type = '".$type."') AND pap.remorque_id = ". $remorque_id;

        $papier = collect(DB::select($sql));

        return $papier;
        
    }
}
