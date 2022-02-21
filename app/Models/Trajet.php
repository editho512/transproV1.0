<?php

namespace App\Models;

use App\Models\Chauffeur;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    private static $coleurs = [];


    /**
     * Methode qui retourne le nom de l'itineraire
     *
     * @return  string  le nom de l'itinéraire
     */
    public function nomItineraire() : string
    {
        return $this->id . ' - ' . $this->depart . ' - ' . $this->arrivee;
    }


    /**
     * Méthode permettat de recuperer tous les itinéraires comportant ce trajet
     *
     * @return HasMany
     */
    public function itineraires() : HasMany
    {
        return $this->hasMany(Itineraire::class, 'id_trajet', 'id');
    }


    /**
     * Recupere le chauffeur qui a fait de trajet
     *
     * @return BelongsTo
     */
    public function chauffeur() : BelongsTo
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id', 'id');
    }


    /**
     * Accesseur pour l'etat d'un trajet
     * Si la clé est nulle, la methode retourne le tableau contenant tous les état
     *
     * @param integer|null $key Clé de l'état.
     * @return string[]|string Une état ou tableau contenant tous les états
     */
    public static function getEtat(int $key = null)
    {
        if ($key === null) return self::$etat;

        try
        {
            return self::$etat[$key];
        }
        catch (Exception $e)
        {
            dd('Erreu : ' , $e->getMessage());
        }
    }


    /**
     * Recuperer un camion concérné par ce trajet
     *
     * @return BelongsTo
     */
    public function camion() : BelongsTo
    {
        return $this->belongsTo(Camion::class, 'camion_id', 'id');
    }


    /**
     * Recuperer tous les trajets meme jours que celle ci
     *
     * @return array
     */
    public function trajetsMemeJour() : array
    {
        $camion = $this->camion;
        $this_depart = Carbon::parse($this->date_heure_depart, 'EAT');

        foreach ($camion->trajets as $trajet)
        {
            $depart = Carbon::parse($trajet->date_heure_depart, 'EAT');

            if ($this_depart->toDateString() === $depart->toDateString())
            {
                $found[$trajet->id] = $depart->toTimeString();
            }
        }

        return [$this_depart->toDateString() => $found];
    }


    /**
     * Generer automatiquement des couleurs pour les trajets de même jour
     *
     * @return void
     */
    public function couleurs()
    {
        $date = Carbon::parse($this->date_heure_depart)->toDateString();

        if (key_exists($date, static::$coleurs))
        {
            return static::$coleurs[$date];
        }

        $trajets = $this->trajetsMemeJour();

        foreach ($trajets as $key => $value)
        {
            static::$coleurs[$key] = "#" . substr(str_repeat(str_shuffle('ABCDEF0123456789'), 1), 0, 6);
        }

        return static::$coleurs[$date];
    }


    /**
     * Permet de determiner l'ordre d'éxecution d'un trajet si il y en a plusieurs
     * dans une meme journée
     *
     * @return int Numero d'ordre d'execution
     */
    public function ordreExecution() : ?int
    {
        $camion = $this->camion;
        $this_depart = Carbon::parse($this->date_heure_depart, 'EAT');

        $found = [
            $this->id => $this_depart->toTimeString()
        ];

        foreach ($camion->trajets as $trajet)
        {
            if ($this->id !== $trajet->id)
            {
                $depart = Carbon::parse($trajet->date_heure_depart, 'EAT');

                if ($this_depart->toDateString() === $depart->toDateString())
                {
                    $found[$trajet->id] = $depart->toTimeString();
                }
            }
        }

        if (count($found) === 1)
        {
            return null;
        }

        ksort($found);
        return array_search($this->id, array_keys($found)) + 1;
    }


    /**
     * Methode permettant de determiner si un trajet est en rétard ou non
     *
     * @return boolean True en retard, False non
     */
    public function enRetard() : bool
    {
        if ($this->etat === self::getEtat(1))
        {
            if ($this->date_heure_arrivee !== null AND Carbon::parse($this->date_heure_arrivee)->lessThan(Carbon::now()))
            {
                return true;
            }
        }

        if ($this->etat === self::getEtat(0))
        {
            if ($this->date_heure_depart !== null AND Carbon::parse($this->date_heure_depart)->lessThan(Carbon::now()))
            {
                return true;
            }
        }

        return false;
    }
}
