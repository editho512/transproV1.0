<?php

use App\Models\Camion;
use App\Models\Depense\Depense;
use App\Models\Maintenance\Maintenance;
use App\Models\Trajet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

if(!function_exists("nombre_fr")){
    /***
    * Fonction permetant de formater les nombre en format français
    *
    * @return double
    */

    function nombre_fr($nombre){
        return number_format($nombre, 0, ",", " ");
    }

}

if(!function_exists("prix_mg")){
    /***
    * Fonction permetant de formater les nombre en format français
    *
    * @return double
    */

    function prix_mg($nombre){
        return nombre_fr($nombre) . " Ar";
    }

}

function allTrajetsAPrevoir()
{
    return Trajet::trajetsAPrevoir();
}


/**
* Fonction permet de detecter si un trajet a depasser la limite d'arrivée
* Le trajet concerné sont les trajet en cours et les trajets a prevoir
*
* @return void
*/
function detecterSiDateArriveeTrajetEnCoursDepasse(Camion $camion)
{
    $trajets = $camion->trajets()->where('etat', Trajet::getEtat(1))->get();

    $messages = [];

    foreach ($trajets as $trajet)
    {
        if ($trajet->date_heure_arrivee !== null)
        {
            $date_heure_arrivee = Carbon::parse($trajet->date_heure_arrivee);
            $now = Carbon::now('EAT');

            if ($date_heure_arrivee->lessThan($now))
            {
                $messages[$trajet->id] = "Le trajet numéro {$trajet->id} est en rétard. Date et heure d'arrivée depassé. Il faut le mettre a jour";
            }
        }
    }

    return $messages;
}


/**
* Permet de detecter si un des trajet a prévoir d'un camion est en retard de départ
*
* @param Camion $camion
* @return void
*/
function detecterSiDateDepartTrajetPrevoirRetard(Camion $camion)
{
    $trajets = $camion->trajets()->where('etat', Trajet::getEtat(0))->get();

    $messages = [];

    foreach ($trajets as $trajet)
    {
        $date_heure_depart = Carbon::parse($trajet->date_heure_depart);
        $now = Carbon::now('EAT');

        if ($date_heure_depart->lessThan($now))
        {
            $messages[$trajet->id] = "Le trajet numéro {$trajet->id} est en rétard. Date et heure départ rétard. Il faut le mettre a jour";
        }
    }

    return $messages;
}



if (!function_exists('formatDate'))
{
    /**
    * Fonction qui format la date donné avec de l'heure
    *
    * @param string|null $date La date a formater
    * @param boolean $date_time Si on a besoin de l'heure
    * @return string La date formatté
    */
    function formatDate(?string $date = '', bool $date_time = true) : string
    {
        if ($date === null OR $date === '')
        {
            return 'Non définie';
        }

        Carbon::setLocale('fr');
        $date = Carbon::parse($date, 'EAT');

        if ($date_time === true) return ucfirst($date->translatedFormat('l d F Y \à H \h i \m\i\n'));
        return ucfirst($date->translatedFormat('l d F Y'));
    }
}


function typeDepense()
{
    return Depense::getAllType();
}

function typeMaintenance()
{
    return Maintenance::getAllType();
}


function formatMoney(float $number = 0, string $unite = 'Ar')
{
    return number_format($number, 2, '.', ' ') . ' ' . $unite;
}

function totalDepense() : float
{
    return doubleval(Depense::sum('montant'));
}


/**
 * Montant total de tous les maintenances
 *
 * @param Collection|null $maintenances
 * @return float
 */
function totalMaintenance(?Collection $maintenances = null) : float
{
    if ($maintenances === null) $maintenances = Maintenance::all();

    $montant = doubleval($maintenances->sum('main_oeuvre'));

    foreach ($maintenances as $maintenance)
    {
        foreach ($maintenance->pieces as $piece)
        {
            $montant += $piece->pivot->pu * $piece->pivot->quantite;
        }
    }

    return doubleval($montant);

}

function numberToLetter(float $number, string $separateur = ".", string $unite = 'Ariary') : string
{
    $letter = strtoupper(asLetters($number, $separateur) . " " . $unite);
    $parts = explode(' ', $letter);

    if ($parts[0] === 'MILLIONS') $parts[0] = "UN MILLIONS";
    return strtoupper(implode(' ', $parts));
}

function asLetters($number, $separateur = ".")
{
    $convert = explode($separateur, (string) $number);

    $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
    'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

    $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
    60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

    if (isset($convert[1]) && $convert[1] != '') {
        return asLetters($convert[0]).' et '.asLetters($convert[1]);
    }
    if ($number < 0) return 'moins '.asLetters(-$number);
    if ($number < 17) {
        return $num[17][$number];
    }
    elseif ($number < 20) {
        return 'dix-'.asLetters($number-10);
    }
    elseif ($number < 100) {
        if ($number%10 == 0) {
            return $num[100][$number];
        }
        elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
                return asLetters((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
                return 'soixante-et-onze';
            }
            elseif ($number == 81) {
                return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
                return 'quatre-vingt-onze';
            }
        }
        elseif ($number < 70) {
            return asLetters($number-$number%10).'-'.asLetters($number%10);
        }
        elseif ($number < 80) {
            return asLetters(60).'-'.asLetters($number%20);
        }
        else {
            return asLetters(80).'-'.asLetters($number%20);
        }
    }
    elseif ($number == 100) {
        return 'cent';
    }
    elseif ($number < 200) {
        return asLetters(100).' '.asLetters($number%100);
    }
    elseif ($number < 1000) {
        return asLetters((int)($number/100)).' '.asLetters(100).($number%100 > 0 ? ' '.asLetters($number%100): '');
    }
    elseif ($number == 1000){
        return 'mille';
    }
    elseif ($number < 2000) {
        return asLetters(1000).' '.asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
        return asLetters((int)($number/1000)).' '.asLetters(1000).($number%1000 > 0 ? ' '.asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
        return 'millions';
    }
    elseif ($number < 2000000) {
        return asLetters(1000000).' '.asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
        return asLetters((int)($number/1000000)).' '.asLetters(1000000).($number%1000000 > 0 ? ' '.asLetters($number%1000000): '');
    }
}


function montantPieces(Collection $maintenances) : float
{
    $montant = 0;

    foreach ($maintenances as $maintenance)
    {
        foreach ($maintenance->pieces as $piece)
        {
            $montant += $piece->pivot->pu * $piece->pivot->quantite;
        }
    }

    return doubleval($montant);
}
