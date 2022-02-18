<?php

namespace App\Models;

use App\Models\Chauffeur;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Stmt\Catch_;

class Trajet extends Model
{
    use HasFactory;

    protected $fillable = [
        'depart', 'date_heure_depart', 'arrivee', 'date_heure_arrivee', 'etat', 'camion_id', 'chauffeur_id',
    ];

    private static $etat = [
        0 => 'A prévoir',
        1 => 'En cours',
        2 => 'Terminé',
    ];

    /**
     * Methode qui retourne le nom de l'itineraire
     *
     * @return  string  le nom de l'itinéraire
     */
    public function nomItineraire() : string
    {
        return $this->id . ' - ' . $this->depart . ' - ' . $this->arrivee;
    }

    public function chauffeur() : BelongsTo
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id', 'id');
    }


    public static function getEtat(int $key) : string
    {
        try
        {
            return self::$etat[$key];
        }
        catch (Exception $e)
        {
            dd('Erreu : ' , $e->getMessage());
        }
    }
}
