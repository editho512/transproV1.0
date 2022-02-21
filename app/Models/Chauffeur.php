<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chauffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'cin', 'permis'
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


    public function estDispoEntre(Carbon $depart, ?Carbon $arrivee)
    {
        $trajets = $this->trajets()->where('date_heure_depart', '>', $depart->toDateTimeString());

        if ($arrivee !== null)
        {
            $trajets = $trajets->orWhere('date_heure_arrivee', '>', $arrivee->toDateTimeString());
        }

        if ($trajets->count() === 0) return true;
        else return false;
    }


    public function nombreTrajetEnAttente() : int
    {
        return $this->trajets()->where('etat', Trajet::getEtat(0))->count();
    }
}
