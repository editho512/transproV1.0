<?php

namespace App\Models\Maintenance;

use App\Models\Camion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    private const ALL_TYPE = [
        'Reparation', 'Maintenance',
    ];


    protected $fillable = [
        "titre", "date_heure", "camion_id", "type", "commentaire", "nom_reparateur", "tel_reparateur", "adresse_reparateur", "main_oeuvre", "pieces"
    ];


    public function montantTotal() : float
    {
        $montant = $this->main_oeuvre;

        foreach (json_decode($this->pieces, true) as $piece)
        {
            $montant += $piece['pu'] * $piece['quantite'];
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

    public static function getAllType()
    {
        return self::ALL_TYPE;
    }
}
