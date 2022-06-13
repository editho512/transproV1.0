<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remorque;
use App\Models\Camion;
use Illuminate\Support\Facades\Validator;
use App\Rules\TypePapier;
use App\Models\RemorquePapier;
use App\Models\TrajetRemorque;



class RemorqueController extends Controller
{
    //

    public function index(){

        $remorques = Remorque::all();

        $active_remorque_index = "active";

        return view('Remorque.index', compact('remorques' , 'active_remorque_index'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
                'name' => 'required|unique:remorques,name|min:2',
            ]
        );
        
        if ($validator->fails()){
            $request->session()->flash("notification", [
                    "value" => "Ajout de remorque échoué" ,
                    "status" => "danger"
                ]
            );
        }

        if ($validator->passes()){
            
            $remorque = request()->all();
            Remorque::create($remorque);
            $request->session()->flash("notification", [
                "value" => "Remorque ajouté" ,
                "status" => "success"
                ]
            );
        }

        return redirect()->back();
       
    }

    public function edit(Remorque $remorque){

        return response()->json($remorque);
    }

    public function update(Request $request, Remorque $remorque){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:remorques,name,' . $remorque->id . '|min:2',
        ]
    );
    
    if ($validator->fails()){
        $request->session()->flash("notification", [
                "value" => "Modification de remorque échoué" ,
                "status" => "danger"
            ]
        );
    }

    if ($validator->passes()){
        
        $data = request()->except(["_token", "_method"]);

        Remorque::where('id', $remorque->id)->update($data);

        $request->session()->flash("notification", [
            "value" => "Remorque modifié" ,
            "status" => "success"
            ]
        );
    }

    return redirect()->back();
    }

    public function delete(Request $request, Remorque $remorque){
        $remorque->delete();

        $request->session()->flash("notification", [
            "value" => "Remorque supprimer" ,
            "status" => "success"
            ]
        );

        return redirect()->back();
    }


    public function voir(Remorque $remorque){
        $papiers = RemorquePapier::all();
        $active_remorque_index = "active";
       
        return view('Remorque.voir', compact('active_remorque_index', 'remorque', 'papiers'));
    }

    public function ajouter_papier(Request $request){
        $validator = Validator::make($request->all(), [
                "designation" => "required",
                "date_obtention" => "required|date",
                "date_echeance" => "required|date",
                "type" => ["required", new TypePapier()],
                "photo" => "sometimes|mimes:doc,docx,pdf,jpg,png,jfif",
                "remorque_id" => "required|exists:remorques,id"
                ]
            );
            
            if ($validator->fails()){
                $request->session()->flash("notification", [
                        "value" => "Ajout de papier échoué" ,
                        "status" => "danger"
                    ]
                );
            }

            if ($validator->passes()){
                $data = $request->all();
                if($request->file("photo") !== null ){

                    $name = $request->file('photo')->getClientOriginalName();
                    $data["photo"] = $request->file('photo')->store('papiers', 'public');
                }else{
                    $data["photo"] = null;
                }
                
                $data["date"] = date("Y-m-d H:i:s", strtotime($data["date_obtention"]));
                $data["date_echeance"] = date("Y-m-d H:i:s", strtotime($data["date_echeance"]));
                $papier = RemorquePapier::create($data);
                
                $request->session()->flash("notification", [
                    "value" => "Papier ajouté" ,
                    "status" => "success"
                    ]
                );
            }
            
            return redirect()->back();
        }

        public function modifier_papier(RemorquePapier $papier){
            return response()->json($papier);
        }

        public function update_papier(Request $request, RemorquePapier $papier){
            $validator = Validator::make($request->all(), [
                "designation" => "required",
                "date" => "required|date",
                "date_echeance" => "required|date",
                "type" => ["required", new TypePapier()],
                "photo" => "sometimes|mimes:doc,docx,pdf,jpg,png,jfif"
                ]
            );
            
            if ($validator->fails()){
                $request->session()->flash("notification", [
                        "value" => "Modification de papier échoué" ,
                        "status" => "danger"
                    ]
                );
            }

            if ($validator->passes()){
                $data = $request->except(['_token', '_method']);
                if($request->file("photo") !== null ){

                    $name = $request->file('photo')->getClientOriginalName();
                    $data["photo"] = $request->file('photo')->store('papiers', 'public');
                }else{
                    $data["photo"] = null;
                }
                
                $data["date"] = date("Y-m-d H:i:s", strtotime($data["date"]));
                $data["date_echeance"] = date("Y-m-d H:i:s", strtotime($data["date_echeance"]));
                RemorquePapier::where('id', $papier->id)->update($data);
                
                $request->session()->flash("notification", [
                    "value" => "Papier Modifié" ,
                    "status" => "success"
                    ]
                );
            }
            
            return redirect()->back();
        }

        public function supprimer_papier(Request $request, RemorquePapier $papier){
            $papier->delete();

            $request->session()->flash("notification", [
                "value" => "Papier supprimé" ,
                "status" => "success"
                ]
            );

            return redirect()->back();
        }

        public function dernier_remorque(Camion $camion){
            $data = [];
            $trajet = $camion->dernierTrajet(false, true);
            
            if($trajet != null){
                
                $remorques = TrajetRemorque::where("trajet_id", $trajet->id)->get("remorque_id")->toArray();
                foreach ($remorques as $key => $value) {
                    array_push($data, $value['remorque_id']);
                }
            }

            return response()->json($data);
        }


}
