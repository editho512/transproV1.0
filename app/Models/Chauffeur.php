<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chauffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'cin', 'permis'
    ];

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
}
