<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class UserController extends Controller
{
    private $notification = null;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::all();
        $active_parametre_index = 'active';
        return view('Utilisateur.utilisateurIndex', compact("users", "active_parametre_index" ));
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['sometimes']
        ]);
        // Check validation failure
        if ($validator->fails()) {
            // [...]
            $errors = $validator->errors();
            Session::put("notification", ["value" => "Echec d'ajout d'utilisateur" ,
                                                "status" => "error"
                                        ]);
            return response()->json($errors);
        }
    
        // Check validation success
        if ($validator->passes()) {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
         

            User::create($data);
            
            Session::put("notification", ["value" => "Utilisateur ajouté" ,
                                                "status" => "success"
                                        ]);
            return response()->json(["success" => true]);
            
        } 
    }

    public function afficher(User $user){
        return response()->json($user);
    }

    public function update(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['sometimes'],
            'type' => ['sometimes']
        ]);
        // Check validation failure
        if ($validator->fails()) {
            // [...]
            $errors = $validator->errors();
            Session::put("notification", [  "value" => "Echec de modification d'utilisateur" ,
                                            "status" => "error"
                                        ]);
            return response()->json($errors);
        }
    
        // Check validation success
        if ($validator->passes()) {
            $data = $request->all();
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->type = $data["type"];
            if($data["password"] != null){
                $user->password = Hash::make($data["password"]);
            }
    
            $user->update();
            
            Session::put("notification", [  "value" => "Utilisateur ajouté" ,
                                            "status" => "success"
                                        ]);
            return response()->json(["success" => true]);
            
        } 
        
    }

    public function delete(User $user){
        $user->delete();
        Session::put("notification", [  "value" => "Utilisateur supprimé" ,
        "status" => "success"]);
        return redirect()->back();
    }
    
}
