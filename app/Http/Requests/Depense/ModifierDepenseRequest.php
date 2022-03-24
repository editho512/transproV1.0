<?php

namespace App\Http\Requests\Depense;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ModifierDepenseRequest extends FormRequest
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
     * Règles de validation de la réquete
     *
     * @return array
     */
    public function rules()
    {
        return [
            "type" => ['required', 'min:5', 'max:255'],
            "date_heure" => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            "camion_id" => ['nullable', 'numeric', 'exists:camions,id'],
            "chauffeur_id" => ['nullable', 'numeric', 'exists:chauffeurs,id'],
            "commentaire" => ['nullable', 'sometimes', 'min:5', 'max:5000'],
            "montant" => ['required', 'numeric', 'min:1', 'max:999999999999'],
        ];
    }


    /**
     * Message d'erreur
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "type.required" => "Vous devez selectionner un type dans la liste",
            "date_heure.required" => "Vous devez renseigner la date et heure",
            "camion_id.exists" => "Le camion que vous avez selecitonné n'exise pas",
            "chauffeur_id.exists" => "Le chauffeur que vous avez selectionné n'existe pas",
            "commentaire.min" => "Le commentaire doit contenir au moins :min caractères",
            "montant.required" => "Le montant est obligatoire",
            "montant.min" => "Le montant doit etre supérieur ou égal à :min",
            "montant.max" => "Le montant doit etre inférieur ou égal à :max",
        ];
    }


    protected function prepareForValidation()
    {
        if ($this->date_heure !== null) $this->merge(['date_heure' => Carbon::parse($this->date_heure, 'EAT')->toDateTimeString()]);
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
