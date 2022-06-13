<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trajet;
use Carbon\Carbon;

class Remorque extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function trajets(){

        return $this->belongsToMany(Trajet::class, "trajet_remorques");
    }

    public function estDispoEntre(Carbon $date_depart, Carbon $date_arrivee, $trajet = null)
    {
        $depart = Trajet::where("trajets.date_heure_depart", ">=", $date_depart->toDateTimeString() )
        ->where("trajets.date_heure_depart", "<=", $date_arrivee->toDateTimeString());

        $arrivee = Trajet::where("trajets.date_heure_arrivee", ">=", $date_depart->toDateTimeString() )
        ->where("trajets.date_heure_arrivee", "<=", $date_arrivee->toDateTimeString());

        if($trajet != null){
            $depart = $depart->where("trajets.id", "!=", $trajet->id);
            $arrivee = $arrivee->where("trajets.id", "!=", $trajet->id);
        }

        $depart = $depart->join("trajet_remorques", "trajet_remorques.trajet_id", "=", "trajets.id")->where("trajet_remorques.remorque_id", $this->id)->get();
        $arrivee = $arrivee->join("trajet_remorques", "trajet_remorques.trajet_id", "=", "trajets.id")->where("trajet_remorques.remorque_id", $this->id)->get();
        return !isset($depart[0]->id) && !isset($arrivee[0]->id);
    }
}
