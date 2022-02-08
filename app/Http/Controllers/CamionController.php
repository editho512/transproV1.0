<?php

namespace App\Http\Controllers;

use File;
use Session;
use App\Models\Camion;
use App\Models\Carburant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CamionController extends Controller
{
    //
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $camions = Camion::all();
        $active_camion_index = "active";
        return view("Camion.camionIndex", compact("active_camion_index", "camions" ));
    }

  
    public function add(Request $request){
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
    
            if ($validator->passes()) {
               
                $name = $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->store('camions', 'public');
        
                $camion->photo = $path;
                $camion->update();
            }


        }
        Session::put("notification", ["value" => "Camion ajouté" , "status" => "success" ]);
        return redirect()->back();
    }

    public function modifier(Camion $camion){
        return response()->json($camion);
    }

    public function update(Request $request, Camion $camion){

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

    public function voir(Camion $camion){

        if($camion->blocked == false){
            $active_camion_index = "active";
            $carburants = Carburant::all();
            $stock_carburant = $this->CarburantRestant($camion->id);
            return view("Camion.voirCamion", compact("active_camion_index", "camion", "carburants", "stock_carburant"));
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
