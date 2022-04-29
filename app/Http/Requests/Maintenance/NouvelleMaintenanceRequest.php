<?php

namespace App\Http\Requests\Maintenance;

use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NouvelleMaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "type" => ["required", "sometimes", "in:Reparation,Maintenance"],
            "titre" => ["required", "min:5", "max:255", "sometimes"],
            "date_heure" => ["required", "date", "date_format:Y-m-d H:i:s", 'before_or_equal:' . Carbon::now('EAT')->toDateTimeString()],
            "camion_id" => ["required", "numeric", "exists:camions,id"],
            "main_oeuvre" => ["required", "numeric", "min:1", "max:999999999999"],
            "commentaire" => ["nullable", "sometimes", "min:5", "max:5000"],
            "nom_reparateur" => ["required", "sometimes", "min:2", "max:500"],
            "tel_reparateur" => ["required", new PhoneNumber],
            "adresse_reparateur" => ["required", "sometimes"],
            "pieces" => ["nullable", "sometimes"],
        ];
    }

    public function messages() : array
    {
        return [
            "type.required" => "Le type est obligatoire (Reparation / Maintenance)",
            "titre.required" => "Vous devez specifier un titre",

            "date_heure.required" => "La date et heure est obligatoire",
            "date_heure.before_or_equal" => "La date et heure ne doit pas depasser :date",

            "camion_id.required" => "Vous devez selectionner un camion",
            "camion_id.exists" => "Le camion selectionné n'existe pas",

            "main_oeuvre.required" => "Vous devez remplir le montant de la main d'oeuvre",
            "main_oeuvre.min" => "Le montant doit être superieur ou égal a :min",
            "nom_reparateur.required" => "Le nom de l'agent est obligatoire",

            "tel_reparateur.required" => "Le telephone de l'agent est obligatoire",
            "tel_reparateur.regex" => "Le format du téléphone est invalide",

            "adresse_reparateur.required" => "L'adresse de l'agent est obligatoire",
        ];
    }


    /**
     * Traitements avant la validation de la réquete
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->tel_reparateur !== null) $this->merge(['tel_reparateur' => str_replace(' ', '', $this->tel_reparateur)]);
        if ($this->date_heure !== null) $this->merge(['date_heure' => Carbon::parse($this->date_heure, 'EAT')->toDateTimeString()]);
        if (json_decode($this->pieces, true) === []) $this->merge(['pieces' => null]);
    }


    protected function failedValidation(Validator $validator)
    {
        $message = "Les champs ne sont pas bien remplis";

        if (request()->ajax())
        {
            throw new HttpResponseException(response()->json([
                "errors" => $validator->errors(),
                "message" => $message
            ], 422));
        }
        return back()->withErrors($validator)->withInput();
    }
}
