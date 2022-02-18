<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\Diagnostique;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Services\Hospitalisation\Hospitalisation;

/**
* Permet de calculer le temps passé enntre deux date
*
* @param string $date_time La date début
* @return string Difference en string de date donnee et maintenant
*/
function timePassed(string $date_time) : string
{
    Carbon::setLocale('fr');
    $date = Carbon::parse($date_time, 'EAT');
    $now = Carbon::now('EAT');

    $difference = $date->diff($now);

    if ($difference->days > 0)
    {
        return ucfirst($date->translatedFormat('l d F Y')) . ' à ' . ucfirst($date->translatedFormat('H:i'));
    }
    else
    {
        if ($difference->h > 0)
        {
            return "Il ya " . $difference->h . " Heures et " . $difference->i . " minutes" ;
        }

        if ($difference->i === 0)
        {
            return "A l'instant";
        }

        return "Il ya " . $difference->i . " minutes" ;
    }
}


/**
* Fonction qui renvoie la couleur en fonction du status
*
* @param string $status
* @return void
*/
function couleur(?string $status) : ?string
{
    if ($status === null) return null;
    $colors = [
        'En cours' => "badge badge-warning-lighten",
        'Terminé' => "badge badge-success-lighten",
        'Annulé' => "badge badge-danger-lighten",
    ];

    return $colors[$status];
}


/**
* Retourne le mode d'emplois de la planification familliale
*
* @return array Les modes d'emplois
*/
function modeEmplois() : array
{
    return [
        "Mode d'emploi 1",
        "Mode d'emploi 2",
        "Mode d'emploi 3",
    ];
}


/**
* Retourne le mode d'emplois de la planification familliale
*
* @return array Les modes d'emplois
*/
function methodes() : array
{
    return [
        "Contraceptives hormonales",
        "Contraceptives non hormonales",
    ];
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

        if ($date_time === true) return ucfirst($date->translatedFormat('l d F Y à H:i'));
        return ucfirst($date->translatedFormat('l d F Y'));
    }
}


/**
* Les methodes d'accouchement
*
* @return array
*/
function methodeAccouchement() : array
{
    return [
        "Vaginale spontanée",
        "Vaginale opérative",
        "Césarienne",
        "Salpingostomie",
        "Forceps",
        "Dilatation et curetage",
        "Travail induit",
    ];
}


function alimentationBebe()
{
    return [
        "Allaitement au biberon",
        "Allaitement maternel",
        "Mixte",
    ];
}


function conditionAccouchement()
{
    return [
        "Normale",
        "Traitement des soins intensifs",
    ];
}


function getYear(int $age)
{
    $date = Carbon::now()->modify("-$age year")->format("Y-m-d");
    return $date;
}


function statusSuiviGyneco()
{
    return [
        "En cours",
        "Accouchement à terme",
        "Accouchement prématuré",
        "Avortement précoce",
        "Accouchement tardif",
    ];
}


/**
* Undocumented function
*
* @param string $matricule
* @return void
*/
function personnelInfo(string $matricule)
{
    return Personnel::findOrFail($matricule)->nomComplet();
}


function typePaiement()
{
    return [
        0 => "Consultation",
        1 => "Infirmerie",
        2 => "Hospitalisation",
        3 => "Mini services",
        4 => "Echographie",
        5 => "Analyse",
        6 => "Chirurgie",
        7 => "Planification familliale",
        8 => "Naissance",
        9 => "Vaccination",
    ];
}


/**
* Formatter une taille d'une personne
*
* @param integer $taille Taille en Centi-mètre
* @return string Taille formaté : 1m70
*/
function formatTaille(int $taille) : string
{
    if ($taille < 100) return $taille . "Cm";

    if ($taille === 100) return "1M";

    if ($taille === 200) return "2M";

    if ($taille > 100 AND $taille < 200)
    {
        $reste = $taille - 100;
        return "1m$reste";
    }

    if ($taille > 200 AND $taille < 300)
    {
        $reste = $taille - 200;
        return "2m$reste";
    }

    throw new Exception('Erreur de formattage');
}


/**
*
*/
if (! function_exists('getYearFromDate')) {

    /**
    * Recuperer l'annee de naissance a partir de la date de naissance
    *
    * @param string|null $date Date de naissance
    * @return string Annee de naissance
    */
    function getYearFromDate(?string $date = "1998-06-22") : string
    {
        $dateTime = new DateTime($date);
        return $dateTime->format('Y');
    }
}


if (! function_exists('age')) {

    /**
    * Fonction qui calcule l'age du patient en fonction de sa date de naissance
    *
    * @param string|null $birth_date Date de naissance
    * @return string|null Age sous forme de string
    */
    function age(?string $birth_date = "1998-06-22") : ?string
    {
        $birth = Carbon::parse($birth_date);
        $now = Carbon::now();

        if ($birth->diffInYears($now) > 0)
        {
            return $birth->diffInYears($now) . " Ans";
        }
        elseif ($birth->diffInMonths($now) > 0)
        {
            return $birth->diffInMonths($now) . " Mois";
        }
        elseif ($birth->diffInWeeks($now) > 0)
        {
            return $birth->diffInWeeks($now) . " Semaines";
        }
        elseif ($birth->diffInDays($now) > 0)
        {
            return $birth->diffInDays($now) . " Jour";
        }
        else
        {
            return "Vient d'être née aujourd'hui";
        }
    }
}


if (! function_exists('numero')) {

    function numero(string $model, string $prefix = 'PX') : string
    {
        $model = new $model();
        $primary_key = $model->getKeyName();
        $last = $model->withTrashed()->latest($primary_key)->first();

        if($last === null)
        {
            $dernier_numero = $prefix . "-0000-" . date("Y");
        }
        else
        {
            $dernier_numero = $last->$primary_key;
            $prefix = explode('-', $dernier_numero)[0];
        }

        $parts = explode('-', $dernier_numero);

        if (last($parts) !== date('Y'))
        {
            $last_number = 0;
        }
        else
        {
            $last_number = (int) $parts[1];
        }


        $count = strlen($parts[1]);
        $count_non_zero = strlen((string) ((int) $parts[1]));

        $count = $count - $count_non_zero;

        if ($last_number === 9 OR $last_number === 99 OR $last_number === 999) $count = $count - 1;

        $zero = "";
        for ($i=0; $i < $count; $i++)
        {
            $zero .= "0";
        }

        $nouveau_numero = $prefix ."-". $zero . (string) ($last_number + 1) . "-" . date("Y");

        return $nouveau_numero;
    }

}


if (!function_exists("services_type"))
{
    /**
    * Fonction qui retourne tous les type de service pour la salle d'attente
    *
    * @param int|null $key Clé a rechercher dans le tableau
    * @return array|string Les types ou un type en particulier en fonction de la clé
    * @throws Exception
    */
    function services_type(int $key = null)
    {
        $services_type = [
            1 => "Consultation générale",
            2 => "Consultation spécialisé",
            3 => "Services personalisée",
        ];

        if ($key === null)
        {
            return $services_type;
        }

        if (array_key_exists($key, $services_type))
        {
            return $services_type[$key];
        }

        throw new \Exception("Element n'existe pas dans type de service");
    }
}


if (!function_exists("services_type_url"))
{
    /**
    * Fonction qui retourne tous les type de service pour la salle d'attente
    *
    * @return array Les types
    */
    function services_type_url($key = null)
    {
        $services_type = [
            1 => "consultation/nouveau",
            2 => "services",
            3 => "services",
        ];

        if ($key === null)
        {
            return $services_type;
        }

        if (array_key_exists($key, $services_type))
        {
            return $services_type[$key];
        }
        throw new \Exception("Element n'existe pas dans type de service");
    }
}


if (!function_exists("services"))
{
    /**
    * Fonction qui renvoie tous les services
    *
    * @return array Les services
    */
    function services($key = null)
    {
        $services = [
            1 => "Infirmerie",
            2 => "Accouchement",
            3 => "Vaccination",
            4 => "Echographie",
            5 => "Chirurgie",
            6 => "Hospitalisation",
            7 => "Analyse",
            8 => "Planification familliale",
            9 => "Gyneco-obstetric",
            10 => "Mini services",
        ];

        if ($key === null)
        {
            return $services;
        }

        if (array_key_exists($key, $services))
        {
            return $services[$key];
        }
        throw new \Exception("Element n'existe pas dans services");
    }
}


if (!function_exists("services_url"))
{
    /**
    * Fonction qui renvoie tous les services
    *
    * @param int $key Clé pour cibler un element particulier
    * @return array Les services
    */
    function services_url(int $key = null)
    {
        $urls = [
            1 => "infirmerie/nouveau",
            2 => "pediatrie/naissance/nouveau",
            3 => "pediatrie/vaccination/nouveau",
            4 => "echographie/nouveau",
            5 => "chirurgie/nouveau",
            6 => "hospitalisation/nouveau",
            7 => "analyse/nouveau",
            8 => "planification-familliale/nouveau",
            9 => "gyneco-obstetrique/nouveau",
            10 => "mini-services/liste?nouveau=1",
        ];

        if ($key === null)
        {
            return "";
        }

        if (array_key_exists($key, $urls))
        {
            return $urls[$key];
        }
        throw new \Exception("Element n'existe pas dans les URLS");
    }
}


if (!function_exists("personnel"))
{
    /**
    * Fonction qui recupere le personnel connecté
    *
    * @return mixed Les services
    */
    function personnel() : Personnel
    {
        $personnel =  Auth::user()->personnel;
        return $personnel;
    }
}

if (!function_exists("status"))
{
    /**
    * Fonction qui renvoie la liste des status d'attente
    *
    * @return array Les status
    */
    function status($key = null)
    {
        $status = [
            0 => "En attente",
            1 => "En cours",
            2 => "Terminé",
            3 => "Annulé",
            4 => "Reporté",
        ];

        if ($key === null)
        {
            return $status;
        }

        if (array_key_exists($key, $status))
        {
            return $status[$key];
        }
        throw new \Exception("Element n'existe pas dans les status");
    }
}


if (!function_exists("couleur_status"))
{
    /**
    * Fonction qui renvoie la liste des status d'attente
    *
    * @return array Les status
    */
    function couleur_status($key = null)
    {
        $couleur_status = [
            0 => "badge-warning-lighten",
            1 => "badge-info-lighten",
            2 => "badge-success-lighten",
            3 => "badge-danger-lighten",
            4 => "badge-info-lighten",
        ];

        if ($key === null)
        {
            return $couleur_status;
        }

        if (array_key_exists($key, $couleur_status))
        {
            return $couleur_status[$key];
        }
        throw new \Exception("Element n'existe pas dans les couleurs de status");
    }
}

if (!function_exists("nationalite"))
{
    /**
    * Fonction qui renvoie la liste des nationalités
    *
    * @return array Les status
    */
    function nationalite($key = null)
    {
        $nationalite = [
            0 => "Malagasy",
            1 => "Etranger(ère)",
        ];

        if ($key === null)
        {
            return $nationalite;
        }

        if (array_key_exists($key, $nationalite))
        {
            return $nationalite[$key];
        }
        throw new \Exception("Element n'existe pas dans les status");
    }
}


if (!function_exists("situationMatrimoniale"))
{
    /**
    * Fonction qui renvoie la liste des situations matrimoniales
    * @return array Les situation matrimoniales
    */
    function situationMatrimoniale($key = null)
    {
        $situationMatrimoniale = [
            0 => "Célibataire",
            1 => "Marié(e)",
            3 => "Divorcé(e)",
            4 => "veuf(ve)",
            5 => "Non définie",
        ];

        if ($key === null)
        {
            return $situationMatrimoniale;
        }

        if (array_key_exists($key, $situationMatrimoniale))
        {
            return $situationMatrimoniale[$key];
        }
        throw new \Exception("Element n'existe pas dans les status");
    }
}


if (!function_exists("modePaiement"))
{
    /**
    * Fonction qui renvoie la liste des status d'attente
    *
    * @return array Les status
    */
    function modePaiement($key = null)
    {
        $modePaiement = [
            1 => "Espèce",
            2 => "Chèque",
            3 => "Virement",
        ];

        if ($key === null)
        {
            return $modePaiement;
        }

        if (array_key_exists($key, $modePaiement))
        {
            return $modePaiement[$key];
        }
        throw new \Exception("Element n'existe pas dans les mode de paiement");
    }
}


if (!function_exists("statusPaiement"))
{
    /**
    * Fonction qui renvoie la liste des status d'attente
    *
    * @return array Les status
    */
    function statusPaiement($key = null)
    {
        $statusPaiement = [
            1 => "Effectué",
            2 => "Annulé",
            3 => "Non défini",
        ];

        if ($key === null)
        {
            return $statusPaiement;
        }

        if (array_key_exists($key, $statusPaiement))
        {
            return $statusPaiement[$key];
        }
        throw new \Exception("Element n'existe pas dans les status de paiement");
    }
}


if (!function_exists('truncate'))
{
    /**
    * Fonction qui coupe une logue texte
    *
    * @param string $text Le texte a couper
    * @param integer $len La longueur voulu
    * @return string Le texte coupé
    */
    function truncate(?string $text, $len = 180) : ?string
    {
        if ($text === null)
        {
            return null;
        }

        if( (strlen($text) > $len) )
        {
            $whitespaceposition = strpos($text," ",$len)-1;
            if( $whitespaceposition > 0 )
            $text = substr($text, 0, ($whitespaceposition+1));
            // close unclosed html tags
            if( preg_match_all("|<([a-zA-Z]+)>|",$text,$aBuffer))
            {
                if( !empty($aBuffer[1]) )
                {
                    preg_match_all("|</([a-zA-Z]+)>|",$text,$aBuffer2);
                    if( count($aBuffer[1]) != count($aBuffer2[1]) )
                    {
                        foreach( $aBuffer[1] as $index => $tag )
                        {
                            if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
                            $text .= '</'.$tag.'>';
                        }
                    }
                }
            }
        }

        return $text;
    }
}


if (!function_exists('medcinAdmin'))
{
    function medcinAdmin()
    {
        $admin = auth()->user()->admin;
        $medcin = auth()->user()->personnel->fonction->libelle === 'Médcin';

        return $admin AND $medcin;
    }
}

if (!function_exists('jour'))
{
    function jour(string $date)
    {
        Carbon::setLocale('fr');
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $date = ucfirst($date->translatedFormat('l'));
        return $date;
    }
}


if (!function_exists('aujourDhui'))
{
    function aujourDhui(bool $heure = false)
    {
        Carbon::setLocale('fr');
        $date = Carbon::now('EAT');

        if ($heure === false)
        $date = ucfirst($date->translatedFormat('l d F Y'));
        else
        $date = ucfirst($date->translatedFormat('l d F Y à H:i:s'));

        return $date;
    }
}


if (!function_exists('ariaryFormat'))
{
    function ariaryFormat(float $nombre)
    {
        return number_format($nombre, 2, '.', ' ');
    }
}


if (!function_exists('getIncrement'))
{
    /**
    * Retourne le nouveau identintifiant incremente a partir du dernier enregistré
    *
    * @param string $class Le model en question
    * @return integer La nouvelle clé
    */
    function getIncrement(string $class) : int
    {
        $model = new $class();

        if($model->getKeyType() !== 'int') throw new \Exception("La clé primaire n'est pas un entier : getIncrement");

        $primary_key = $model->getKeyName();

        $last = $model->latest($primary_key)->first();

        if ($last === null)
        {
            return 1;
        }
        return $last->$primary_key + 1;
    }
}


if (!function_exists('updateHospitalisationDay'))
{
    /**
    * Fonction qui mis a jour les hospitalisation
    *
    * @return void
    */
    function updateHospitalisationDay()
    {
        $hospitalisations = Hospitalisation::where('date_heure_sortie', null)->get();

        foreach ($hospitalisations as $hospitalisation)
        {
            $date_entree = Carbon::parse($hospitalisation->date_heure_entree);
            $now = Carbon::now();
            $nombre_jour = $date_entree->diffInDays($now);

            if ($nombre_jour === 0)
            {
                return false;
            }

            $salle = $hospitalisation->salle()->orderBy('date_affectation', 'DESC')->first();

            $ancien_montant = $salle->pivot->montant;
            $montant_a_ajouter = $salle->pivot->prix_unitaire * ($nombre_jour - $salle->pivot->nombre_jour) ;
            $nouveau_montant = $ancien_montant + $montant_a_ajouter;

            $charge_assurance_a_ajouter = $montant_a_ajouter * $hospitalisation->patient->pourcentage / 100;
            $reste_a_payer_a_ajouter = $montant_a_ajouter - $charge_assurance_a_ajouter;

            $nouveau_reste = $reste_a_payer_a_ajouter + $salle->pivot->reste_a_payer;
            $nouveau_charge_assurance = $charge_assurance_a_ajouter + $salle->pivot->charge_assurance;

            $update = $hospitalisation->salle()->updateExistingPivot($salle->numero_salle, [
                'nombre_jour' => $nombre_jour,
                'reste_a_payer' => $nouveau_reste,
                'montant' => $nouveau_montant,
                'charge_assurance' => $nouveau_charge_assurance,
            ]);
        }
    }
}


function superUser()
{
    return auth()->user()->superuser === 1;
}


function getExactDate($begin, $end)
{
    $beginDate = Carbon::now()->modify($begin)->format('Y-m-d');
    $endDate = Carbon::now()->modify($end)->format('Y-m-d');
    return [$endDate, $beginDate];
}


/**
* Undocumented function
*
* @param Diagnostique|null $diagnostic
* @param array $date
* @param string $mois
* @param string $annee
* @return int
*/
function countConsultationNumber(?Diagnostique $diagnostic, array $date, string $mois, string $annee) : int
{
    try
    {
        $count = 0;
        $consultations = Collection::empty();

        if ($diagnostic === null)
        {
            $consultations = Consultation::whereYear('date_heure_consultation', $annee)
            ->whereMonth('date_heure_consultation', $mois)
            ->get();;
        }
        else
        {
            $consultations = $diagnostic->consultations()
            ->whereYear('date_heure_consultation', $annee)
            ->whereMonth('date_heure_consultation', $mois)
            ->get();
        }

        foreach ($consultations as $consultation)
        {
            $count = $count + $consultation->patient()
            ->whereBetween('date_naissance', [getExactDate($date[0], $date[1])])
            ->count();
        }

        return $count;
    }
    catch (Exception $e)
    {
        dd($e->getMessage());
    }
}


function mois()
{
    return [
        '01' => "Janvier",
        '02' => "Fevrier",
        '03' => "Mars",
        '04' => "Avril",
        '05' => "Mai",
        '06' => "Juin",
        '07' => "Juillet",
        '08' => "Août",
        '09' => "Septembre",
        '10' => "Octobre",
        '11' => "Novembre",
        '12' => "Décembre",
    ];
}


function annees()
{
    $years = array_combine(range(date("Y"), 2021), range(date("Y"), 2021));
    return $years;
}

function toLetter(int $number)
{
    $letter = [
        0 => "zero",
        1 => "one",
        2 => "two",
        3 => "three",
    ];

    return $letter[$number];
}


/**
 * Verifier si l'utilisateur es deja connecté
 *
 * @param User $user
 * @return void
 */
function checkIfAlreadyConnected(?User $user)
{
    $user = auth()->user();
    $new_sessid   = Session::getId(); //get new session_id after user sign in
    $last_session = Session::getHandler()->read($user->session_id); // retrive last session

    if ($last_session) {
        if (Session::getHandler()->destroy($user->session_id)) {
            // session was destroyed
        }
    }

    $user->session_id = $new_sessid;
    $user->save();
}


function typeFacture(string $key = 'Consultation')
{
    $type = [
        'Consultation' => 1,
        'Médicaments' => 2,
        'Articles' => 3,
        'Services de la clinique' => 4,
    ];

    try
    {
        return $type[$key];
    }
    catch (Throwable $th)
    {
        throw $th;
    }
}
