<?php

namespace App\Models;

use App\Models\Chauffeur;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function PHPUnit\Framework\returnSelf;

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


    public function camion()
    {
        return $this->belongsTo(Camion::class, 'camion_id', 'id');
    }


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


    public function couleurs()
    {
        $trajets = $this->trajetsMemeJour();

        foreach ($trajets as $key => $value)
        {
            $colors[$key] = "#" . substr(str_repeat(str_shuffle('ABCDEF0123456789'), 8), 0, 6);
        }

        return $colors[Carbon::parse($this->date_heure_depart)->toDateString()];
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function ordreExecution()
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
}
