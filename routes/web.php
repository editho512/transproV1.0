<?php

use App\Http\Controllers\Depense\MainDepenseController;
use App\Http\Controllers\Depense\ModifierDepenseController;
use App\Http\Controllers\Depense\NouvelleDepenseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('accueil');

})->name('index');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// -------------------- PAPIERS ------------------- //

Route::get("/papier/supprimer/{papier}", [App\Http\Controllers\PapierController::class, 'supprimer'])->name("papier.supprimer");

Route::patch("/papier/update/{papier}", [App\Http\Controllers\PapierController::class, 'update'])->name("papier.update");

Route::get("/papier/modifier/{papier}", [App\Http\Controllers\PapierController::class, 'modifier'])->name("papier.modifier");

Route::post("/papier/ajouter", [App\Http\Controllers\PapierController::class, 'ajouter'])->name("papier.ajouter");

Route::get("/papier", [App\Http\Controllers\PapierController::class, 'index'])->name("papier.liste");

// -------------------- PAPIERS ------------------- //

// --------------------- CARBURANTS ---------------//

Route::get('/Carburant/delete/{carburant}/{type?}',  [App\Http\Controllers\CarburantController::class, 'delete'])->name("carburant.delete");

Route::patch('/Carburant/update/{carburant}', [App\Http\Controllers\CarburantController::class, 'update'])->name('carburant.update');

Route::get('/Carburant/modifier/{carburant}', [App\Http\Controllers\CarburantController::class, 'modifier'])->name('carburant.modifier');

Route::post('/Carburant/ajouter', [App\Http\Controllers\CarburantController::class, 'add'])->name('carburant.ajouter');


//----------------------- TRAJETS -----------------//

Route::prefix('trajet')->group(function() {

    Route::get('/delete/{trajet}/{type?}',  [App\Http\Controllers\TrajetController::class, 'delete'])->name("trajet.delete");

    Route::patch('/update/{trajet}', [App\Http\Controllers\TrajetController::class, 'update'])->name('trajet.update');

    Route::get('/modifier/{trajet}', [App\Http\Controllers\TrajetController::class, 'modifier'])->name('trajet.modifier');

    Route::post('/ajouter', [App\Http\Controllers\TrajetController::class, 'add'])->name('trajet.ajouter');

    Route::get('/voir/{trajet}/',  [App\Http\Controllers\TrajetController::class, 'voir'])->name("trajet.voir");

    Route::get('/supprimer/{trajet}',  [App\Http\Controllers\TrajetController::class, 'supprimer'])->name("trajet.supprimer");

});

// ---------------------- CHAUFFEURS ------------- //

Route::get('/Chauffeur/delete/{chauffeur}/{type?}',  [App\Http\Controllers\ChauffeurController::class, 'delete'])->name("chauffeur.delete");

Route::patch('/Chauffeur/update/{chauffeur}', [App\Http\Controllers\ChauffeurController::class, 'update'])->name('chauffeur.update');

Route::get('/Chauffeur/modifier/{chauffeur}', [App\Http\Controllers\ChauffeurController::class, 'modifier'])->name('chauffeur.modifier');

Route::post('/Chauffeur/ajouter', [App\Http\Controllers\ChauffeurController::class, 'add'])->name('chauffeur.ajouter');

Route::get('/Chauffeur', [App\Http\Controllers\ChauffeurController::class, 'index'])->name('chauffeur.liste');


// --------------------- CAMIONS -----------------//

Route::get('/Camion/voir/{camion}/{tab?}/',  [App\Http\Controllers\CamionController::class, 'voir'])->name("camion.voir");

Route::get('/Camion/delete/{camion}/{type?}',  [App\Http\Controllers\CamionController::class, 'delete'])->name("camion.delete");

Route::get('/Camion/supprimer/{camion}',  [App\Http\Controllers\CamionController::class, 'supprimer'])->name("camion.supprimer");

Route::patch('/Camion/update/{camion}', [App\Http\Controllers\CamionController::class, 'update'])->name('camion.update');

Route::get('/Camion/modifier/{camion}', [App\Http\Controllers\CamionController::class, 'modifier'])->name('camion.modifier');

Route::post('/Camion/ajouter', [App\Http\Controllers\CamionController::class, 'add'])->name('camion.ajouter');

Route::get('/Camion', [App\Http\Controllers\CamionController::class, 'index'])->name('camion.liste');


// --------------------- UTILISATEUR -------------//

Route::prefix('Utilisateur')->middleware('super-admin')->group(function () {

    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('utilisateur.liste');

    Route::delete('/delete/{user}', [App\Http\Controllers\UserController::class, 'delete'])->name('utilisateur.delete');

    Route::patch('/update/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('utilisateur.update');

    Route::get('/afficher/{user}', [App\Http\Controllers\UserController::class, 'afficher'])->name('utilisateur.afficher');

    Route::post('/ajouter', [App\Http\Controllers\UserController::class, 'add'])->name('utilisateur.ajouter');

});

// --------------------- UTILISATEUR -------------//


/**
 * Regroupe toutes les toutes qui concerne les depenses
 * URL prefixé par depense/
 */
Route::prefix('depense')->middleware(['auth'])->group(function () {

    // Page d'accueil de la depense
    Route::get('/', [MainDepenseController::class, 'index'])->name('depense.index');

    // Enregistrer un dépense
    Route::get('nouvelle', [NouvelleDepenseController::class, 'create'])->name('depense.nouvelle');
    Route::post('nouvelle', [NouvelleDepenseController::class, 'store'])->name('depense.post.nouvelle');

    // Modifier un dépense
    Route::get('modifier/{depense}', [ModifierDepenseController::class, 'create'])->name('depense.modifier');
    Route::post('nouvelle/{depense}', [ModifierDepenseController::class, 'store'])->name('depense.post.modifier');

    // Supprimer une dépense
    Route::post('supprimer/{depense}', [MainDepenseController::class, 'supprimer'])->name('depense.post.supprimer');

});
