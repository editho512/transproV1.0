<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use App\Models\Carburant;
use App\Models\Chauffeur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CamionController extends Controller
{
    /**
    * Constructeur qui definit les middlewares
    */
    public function __construct()
    {
        $this->middleware('super-admin')->except(['add', 'index', 'voir']);
    }


    /**
    * Afficher la liste des camions
    *
    * @return View
    */
    public function index()
    {
        // Verifier si l'utilisateur peut acceder au dashboard
        if (!Gate::allows('acceder-dashboard'))
        {
            return redirect()->route('index');
        }

        $camions = Camion::all();
        $active_camion_index = "active";

        return view("Camion.camionIndex", compact("active_camion_index", "camions"));
    }


    /**
    * Ajouter un nouveau camion dans la base de données
    *
    * @param Request $request Requete contenant tous les champs
    * @return RedirectResponse
    */
    public function add(Request $request) : RedirectResponse
    {
        $data = $request->except("photo");
        $camion = Camion::create($data);

        if( $request->file('photo') !== null){

            $validator = Validator::make($request->all(), [
                'photo' => 'mimes:jpeg,png,bmp,tiff |max:4096',
            ],
            $messages = [
                'required' => 'Le :attribute est obligatoire.',
                'mimes' => 'Seul jpeg, png, bmp,tiff  est accepté.'
                ]
            );

            if ($validator->passes()){

                $name = $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->store('camions', 'public');

                $camion->photo = $path;
                $camion->update();
            }


        }

        $request->session()->flash("notification", [
            "value" => "Camion ajouté" ,
            "status" => "success"
            ]
        );

        return redirect()->back();
    }


    /**
     * Methode pour modifier un camion
     *
     * @param Camion $camion
     * @return JsonResponse
     */
    public function modifier(Camion $camion) : JsonResponse
    {
        return response()->json($camion);
    }

    /**
     * Enregistrer les modifications d'un camion
     *
     * @param Request $request
     * @param Camion $camion
     * @return void
     */
    public function update(Request $request, Camion $camion)
    {

        $data = $request->except("photo");
        $camion->name = $data["name"];
        $camion->marque = $data["marque"];
        $camion->model = $data["model"];
        $camion->annee = $data["annee"];
        $camion->numero_chassis = $data["numero_chassis"];


        if( $request->file('photo') !== null){


            $validator = Validator::make($request->all(), [
                'photo' => 'mimes:jpeg,png,bmp,tiff |max:4096',
            ],
            $messages = [
                'required' => 'Le :attribute est obligatoire.',
                'mimes' => 'Seul jpeg, png, bmp,tiff est accepté.'
                ]
            );

            if ($validator->passes()) {

                if(File::exists(public_path('storage/'.$camion->photo))){
                    File::delete(public_path('storage/'.$camion->photo));
                }
                $name = $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->store('camions', 'public');
                $camion->photo = $path;
            }


        }
        $camion->update();
        Session::put("notification", ["value" => "Camion modifié" , "status" => "success" ]);
        return redirect()->back();

    }

    public function supprimer(Camion $camion){

        return response()->json($camion);
    }

    public function delete(Camion $camion, $type = 1){
        $msg = "";

        if($type == 1){
            $camion->delete();
            $msg = "Le camion supprimé";
        }
        else if($type == 2){
            $camion->blocked =  true;
            $camion->update();
            $msg = "Le camion bloqué";
        }
        else{
            $camion->blocked = false;
            $camion->update();
            $msg = "Le camion debloqué";
        }

        Session::put("notification", ["value" => $msg , "status" => "success" ]);

        return redirect()->back();
    }

    public function voir(Camion $camion)
    {
        if($camion->blocked == false){
            $active_camion_index = "active";
            $carburants = $camion->carburants;
            $chauffeurs = Chauffeur::orderBy('name', 'asc')->get();

            $stock_carburant = $this->CarburantRestant($camion->id);

            return view("Camion.voirCamion", compact("active_camion_index", "camion", "carburants", "stock_carburant", "chauffeurs"));
        }
    }

    private function CarburantRestant($camion_id){
        $stock =  Carburant::where("camion_id", "=", $camion_id)->groupBy("flux")->selectRaw("sum(quantite) as quantite, flux")->get();
        $stock = $stock->toArray();
        $entre = 0 ;
        $sortie = 0;

        foreach ($stock as $key => $value) {
            # code...
            if($value["flux"] == 0){
                $entre = doubleval($value["quantite"]);
            }else{
                $sortie = doubleval($value["quantite"]);
            }
        }

        return (doubleval($entre) - doubleval($sortie));
    }

}
