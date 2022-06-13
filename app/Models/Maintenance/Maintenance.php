<?php

namespace App\Models\Maintenance;

use App\Models\Camion;
use Illuminate\Support\Facades\DB;
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



    public function mainOeuvre($page = 0){

        $req = self::selectRaw('year(date_heure) year, extract(month from date_heure) month, sum(main_oeuvre) quantite')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'asc')
                    ->skip($page)
                    ->take(5)
                    ->get();
        
        return $req;
    }


    public function montantTotal() : float
    {
        $montant = $this->main_oeuvre;

        if ($this->pieces !== null AND json_decode($this->pieces, true) !== []) {
            foreach (json_decode($this->pieces, true) as $piece)
            {
                $montant += $piece['pu'] * $piece['quantite'];
            }
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

    public static function dashboard($debut = null, $fin = null){

        $req = self::join("camions", "camions.id", "=", "maintenances.camion_id")
                    ->selectRaw("camions.name as camion, maintenances.type, maintenances.pieces, maintenances.main_oeuvre");
        
        if($debut != null){
            $req = $req->where("maintenances.date_heure", ">=", $debut);
        }
        if($fin != null){
            $req = $req->where("maintenances.date_heure", "<=", $fin);
        }

        $req = $req->selectRaw("camions.name as camion, maintenances.type, maintenances.pieces, maintenances.main_oeuvre");

       
        $req = $req->get();

        $res = [];

        foreach ($req as $key => $liste) {
            # code...
            $pieces = doubleval($liste->main_oeuvre);
            $array_pieces = json_decode($liste->pieces);
            
            if( $array_pieces != null ){

                foreach ($array_pieces as $key => $value) {
                    # code...
                    $pieces += doubleval($value->total);
                }
            }

            //array_push($res, ["maintenance" => $liste, "montant" => ($pieces + doubleval($liste->main_oeuvre))]);
            $res[$liste->camion][$liste->type] = isset($res[$liste->camion][$liste->type]) ? $res[$liste->camion][$liste->type] + $pieces : $pieces ;
        }   

        return $res;
    }
}
