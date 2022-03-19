<?php

namespace App\Http\Controllers;

use App\Models\Papier;
use App\Rules\TypePapier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PapierController extends Controller
{
    //
    public function __contruct(){
        $this->middleware('super-admin');
    }

    public function index(){
        //dd(Papier::TYPE);

    }

    public function modifier(Papier $papier){
        return response()->json($papier);
    }

    public function ajouter(Request $request){
        $data = $request->validate(
            [
                "designation" => "required",
                "date_obtention" => "required|date",
                "date_echeance" => "required|date",
                "type" => ["required", new TypePapier()],
                "photo" => "sometimes|mimes:doc,docx,pdf,jpg,png,jfif",
                "camion_id" => "required|exists:camions,id"
            ],
            [
                "designation.required" => "La désignation est obligatoire",
                "date_obtention.required" => "La date d'obtention est obligatoire",
                "date_echeance.required" => "La date d'échéance est obligatoire",
                "type.required" => "Le type de papier est obligatoire",
                "photo.mimes" => "La photo doit être de type doc, docx, pdf, jpg, png et jfif" 
            ]
        );

        if($request->file("photo") !== null ){

            $name = $request->file('photo')->getClientOriginalName();
            $data["photo"] = $request->file('photo')->store('papiers', 'public');
        }else{
            $data["photo"] = null;
        }
        
        $data["date"] = date("Y-m-d H:i:s", strtotime($data["date_obtention"]));
        $data["date_echeance"] = date("Y-m-d H:i:s", strtotime($data["date_echeance"]));
        $papier = Papier::create($data);

        $request->session()->flash("notification", [
            "value" => $papier->designation." ajouté" ,
            "status" => "success"
        ]);

        return response()->json(["status" => "success" , "value" => route("camion.voir", ["camion" => $request->camion_id, "tab" => 3]) ]);
    }

    public function update(Request $request, Papier $papier){
        $data = $request->validate(
            [
                "designation" => "required",
                "date_obtention" => "required|date",
                "date_echeance" => "required|date",
                "type" => ["required", new TypePapier()],
                "photo" => "sometimes|mimes:doc,docx,pdf,jpg,png,jfif",
                "camion_id" => "required|exists:camions,id"
            ],
            [
                "designation.required" => "La désignation est obligatoire",
                "date_obtention.required" => "La date d'obtention est obligatoire",
                "date_echeance.required" => "La date d'échéance est obligatoire",
                "type.required" => "Le type de papier est obligatoire",
                "photo.mimes" => "La photo doit être de type doc, docx, pdf, jpg, png et jfif" 
            ]
        );

        
        if($request->file("photo") !== null ){
            
            if(File::exists(public_path('storage/'.$papier->photo))){
                File::delete(public_path('storage/'.$papier->photo));
            }

            $name = $request->file('photo')->getClientOriginalName();
            $data["photo"] = $request->file('photo')->store('papiers', 'public');
        }else{
            $data["photo"] = null;
        }
        
        $data["date"] = date("Y-m-d H:i:s", strtotime($data["date_obtention"]));
        unset($data["date_obtention"]);
        $data["date_echeance"] = date("Y-m-d H:i:s", strtotime($data["date_echeance"]));

        Papier::where("id", $papier->id)->update($data);

        $request->session()->flash("notification", [
            "value" => $papier->designation. " modifié" ,
            "status" => "success"
        ]);

        return response()->json(["status" => "success" , "value" => route("camion.voir", ["camion" => $request->camion_id, "tab" => 3]) ]);
    
    }

    public function supprimer(Papier $papier){
        if(File::exists(public_path('storage/'.$papier->photo))){
            File::delete(public_path('storage/'.$papier->photo));
        }
        $camion = $papier->camion_id;
        $papier->delete();
        return redirect()->route('camion.voir', ['camion' => $camion, 'tab' => 3]);
    }
}
