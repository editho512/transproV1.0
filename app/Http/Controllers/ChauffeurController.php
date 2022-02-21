<?php

namespace App\Http\Controllers;

use File;
use Session;
use App\Models\Chauffeur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChauffeurController extends Controller
{
    public function __construct()
    {
        $this->middleware('super-admin')->except(['index', 'add']);
    }


    public function index() : View
    {
        $chauffeurs = Chauffeur::all();
        $active_chauffeur_index = "active";
        return view("Chauffeur.chauffeurIndex", compact("active_chauffeur_index", "chauffeurs" ));
    }

    public function add(Request $request){
        $data = $request->except("permis");
        $chauffeur = Chauffeur::create($data);

        if( $request->file('permis') !== null){

            $validator = Validator::make($request->all(), [
                        'permis' => 'mimes:pdf,jpeg,png,bmp,tiff,pdf |max:10096',
                    ],
                    $messages = [
                        'required' => 'Le :attribute est obligatoire.',
                        'mimes' => 'Seul jpeg, png, bmp,tiff et pdf sont acceptés.'
                        ]
                );

            if ($validator->passes()) {

                $name = $request->file('permis')->getClientOriginalName();
                $path = $request->file('permis')->store('permis', 'public');

                $chauffeur->permis = $path;
                $chauffeur->update();
            }



        }
        Session::put("notification", ["value" => "Chauffeur ajouté" , "status" => "success" ]);
        return redirect()->back();
    }

    public function modifier(Chauffeur $chauffeur){
        return response()->json($chauffeur);
    }

    public function update(Request $request, Chauffeur $chauffeur){

        $data = $request->except("permis");
        $chauffeur->name = $data["name"];
        $chauffeur->phone = $data["phone"];
        $chauffeur->cin = $data["cin"];


        if( $request->file('permis') !== null){

            $validator = Validator::make($request->all(), [
                                'permis' => 'mimes:pdf,jpeg,png,bmp,tiff |max:10096',
                            ],
                                $messages = [
                                    'required' => 'Le :attribute est obligatoire.',
                                    'mimes' => 'Seul jpeg, png, bmp,tiff et pdf sont acceptés.'
                                ]
                        );


            if ($validator->passes()) {

                if(File::exists(public_path('storage/'.$chauffeur->permis))){
                    File::delete(public_path('storage/'.$chauffeur->permis));
                }

                $name = $request->file('permis')->getClientOriginalName();
                $path = $request->file('permis')->store('permis', 'public');

                $chauffeur->permis = $path;
            }
        }
        $chauffeur->update();
        Session::put("notification", ["value" => "Chauffeur modifié" , "status" => "success" ]);
        return redirect()->back();

    }

    public function delete(Chauffeur $chauffeur, $type = 1){
        $msg = "";

        if($type == 1){
            $chauffeur->delete();
            $msg = "Le chauffeur supprimé";
        }
        else if($type == 2){
            $chauffeur->blocked =  true;
            $chauffeur->update();
            $msg = "Le chauffeur bloqué";
        }
        else{
            $chauffeur->blocked = false;
            $chauffeur->update();
            $msg = "Le chauffeur debloqué";
        }

        Session::put("notification", ["value" => $msg , "status" => "success" ]);

        return redirect()->back();
    }


}
