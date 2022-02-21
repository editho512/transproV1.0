<?php

use App\Models\Camion;
use App\Models\Trajet;
use Carbon\Carbon;

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



