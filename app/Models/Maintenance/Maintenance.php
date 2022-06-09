<?php

namespace App\Models\Maintenance;

use App\Models\Camion;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Maintenance extends Model
{
    use HasFactory;

    private const ALL_TYPE = [
        'Reparation', 'Maintenance',
    ];


    protected $fillable = [
        "titre", "date_heure", "camion_id", "type", "commentaire", "nom_reparateur", "tel_reparateur", "adresse_reparateur", "main_oeuvre",
    ];

    protected $with = ['camion', 'pieces'];

    protected $withSum = ['main_oeuvre'];


    /**
     * Montant total de la mainténance
     *
     * @return float
     */
    public function montantTotal() : float
    {
        $montant = $this->main_oeuvre;

        foreach ($this->pieces as $piece)
        {
            $montant += $piece->pivot->pu * $piece->pivot->quantite;
        }

        return doubleval($montant);
    }

    /**
     * Recuperer le camion concerné s'il existe
     *
     * @return BelongsTo
     */
    public function camion() : BelongsTo
    {
        return $this->belongsTo(Camion::class);
    }


    /**
     * Affiche les informations du camions
     *
     * @return string
     */
    public function infosCamion() : string
    {
        $camion = $this->camion;

        if ($camion === null) return "Aucune camion";
        return $camion->name;
    }


    /**
     * recuperer tous les types
     *
     * @return array
     */
    public static function getAllType() : array
    {
        return self::ALL_TYPE;
    }


    /**
     * Recuperer tous les pièces associé a la maintenance
     *
     * @return BelongsToMany
     */
    public function pieces() : BelongsToMany
    {
        return $this->belongsToMany(Piece::class, 'maintenance_piece_frs', 'maintenance', 'piece')
            ->withPivot(['pu', 'quantite', 'total']);
    }
}
