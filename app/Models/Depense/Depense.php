<?php

namespace App\Models\Depense;

use App\Models\Camion;
use App\Models\Chauffeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'camion_id', 'chauffeur_id', 'date_heure', 'commentaire', 'montant',
    ];

    const ALL_TYPE = [
        'Contravention', 'Entré au port', 'Nourriture', 'Divers',
    ];


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
     * Recupere le chauffeur concerné par ce depense s'il existe
     *
     * @return BelongsTo
     */
    public function chauffeur() : BelongsTo
    {
        return $this->belongsTo(Chauffeur::class);
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
     * Affiche les informations du chauffeur
     *
     * @return string
     */
    public function infosChauffeur() : string
    {
        $chauffuer = $this->chauffeur;

        if ($chauffuer === null) return "Aucun chauffeur";
        return $chauffuer->name;
    }


    public static function getAllType()
    {
        return self::ALL_TYPE;
    }
    public static function depensePerDriver($debut = null, $fin = null, $type = null){

        $req =  self::join("chauffeurs", "chauffeurs.id", "=", "depenses.chauffeur_id")
                    ->where("depenses.chauffeur_id", "!=", null);
        
        if($debut != null){
            $req = $req->where("depenses.date_heure", ">=", $debut);
        }
        if($fin != null){
            $req = $req->where("depenses.date_heure", "<=", $fin);
        }
        if($type != null){
            $req = $req->where("depenses.type", "=", $type);
        }
                  
        $req = $req->groupBy("depenses.chauffeur_id")
                    ->selectRaw('sum(depenses.montant) as montant, chauffeurs.name as chauffeur');
        return $req->get();
    }

    public static function depensePerCamion($debut = null, $fin = null, $type = null){

        $req =  self::join("camions", "camions.id", "=", "depenses.camion_id")
                    ->where("depenses.camion_id", "!=", null);
        
        if($debut != null){
            $req = $req->where("depenses.date_heure", ">=", $debut);
        }
        if($fin != null){
            $req = $req->where("depenses.date_heure", "<=", $fin);
        }
        if($type != null){
            $req = $req->where("depenses.type", "=", $type);
        }
                  
        $req = $req->groupBy("depenses.camion_id")
                    ->selectRaw('sum(depenses.montant) as montant, camions.name as camion');
        return $req->get();
    }
}
