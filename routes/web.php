<?php

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

Route::get('/Camion/voir/{camion}/',  [App\Http\Controllers\CamionController::class, 'voir'])->name("camion.voir");

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
