<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Chauffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'cin', 'permis', 'user_id'
    ];


    /**
     * Recuperer tous les chauffeurs disponibles de l'agence
     *
     * @return array Tableau contenant tous les chauffeurs
     */
    public static function tousDisponible() : array
    {
        $chauffeurs = [];

        foreach (self::all() as $chauffeur)
        {
            if ($chauffeur->trajets()->where('etat', Trajet::getEtat(1))->count() === 0)
            {
                $chauffeurs[] = $chauffeur;
            }
        }
        return $chauffeurs;
    }


    /**
     * Methode qui récupere tous les trajets faites par un chauffeur
     * Y compris le trajet en cours
     *
     * @return HasMany Relation unique a plusieurs | Un chauffeur peut faire plusieurs trajet
     */
    public function trajets() : HasMany
    {
        return $this->hasMany(Trajet::class, 'chauffeur_id', 'id');
    }


    /**
     * Determiner si un camion est disponible ou non
     *
     * @return boolean True si disponible, False sinon
     */
    public function disponible()
    {
        if (in_array($this, self::tousDisponible())) return true;
        else return false;
    }


    public function estDispoEntre(Carbon $date_depart, Carbon $date_arrivee , $trajet = null)
    {
        $depart = Trajet::where("chauffeur_id", $this->id)
                            ->where("date_heure_depart", ">=", $date_depart->toDateTimeString() )
                            ->where("date_heure_depart", "<=", $date_arrivee->toDateTimeString());



        $arrivee = Trajet::where("chauffeur_id", $this->id)
                    ->where("date_heure_arrivee", ">=", $date_depart->toDateTimeString() )
                    ->where("date_heure_arrivee", "<=", $date_arrivee->toDateTimeString());

        if($trajet != null){
            $depart = $depart->where("id", "!=", $trajet->id);
            $arrivee = $arrivee->where("id", "!=", $trajet->id);
        }

        $depart = $depart->get();
        $arrivee = $arrivee->get();
        return !isset($depart[0]->id) && !isset($arrivee[0]->id);

    }


    public function nombreTrajetEnAttente() : int
    {
        return $this->trajets()->where('etat', Trajet::getEtat(0))->count();
    }


    public function transporteur() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function aUnTrajetEntre(string $date_depart, ?string $date_arrivee)
    {
        $trajets = collect();

        if ($date_arrivee === null)
        {
            $sql = "SELECT trajets.id FROM trajets
            WHERE (trajets.date_heure_depart < ? AND trajets.date_heure_arrivee > ?)
            AND trajets.etat <> ? AND trajets.etat <> ?
            AND trajets.chauffeur_id = ?";

            $trajets = collect(DB::select($sql, [$date_depart, $date_depart, Trajet::getEtat(3), Trajet::getEtat(2),  $this->id]));
        }
        else
        {
            $sql = "SELECT trajets.id FROM trajets
            WHERE ((trajets.date_heure_depart < ? AND trajets.date_heure_arrivee > ?) OR (trajets.date_heure_depart < ? AND trajets.date_heure_arrivee > ?))
            AND trajets.etat <> ? AND trajets.etat <> ?
            AND trajets.chauffeur_id = ?";

            $trajets = collect(DB::select($sql, [$date_depart, $date_depart, $date_arrivee, $date_arrivee, Trajet::getEtat(3), Trajet::getEtat(2),  $this->id]));
        }


        if ($trajets->isEmpty()) return false;
        return true;

    }
}
