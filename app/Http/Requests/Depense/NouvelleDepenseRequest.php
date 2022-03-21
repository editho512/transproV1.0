<?php

namespace App\Http\Requests\Depense;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NouvelleDepenseRequest extends FormRequest
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
            "date_heure" => ['required', 'date', 'date_format:Y-m-d H:i:s', 'before_or_equal:' . Carbon::now('EAT')->toDateTimeString()],
            "camion_id" => ['nullable', 'numeric', 'exists:camions,id'],
            "chauffeur_id" => ['nullable', 'numeric', 'exists:chauffeurs,id'],
            "commentaire" => ['nullable', 'sometimes', 'min:5', 'max:5000'],
            "montant" => ['required', 'numeric', 'min:10', 'max:999999999999'],
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
        ];
    }


    /**
     * Traitements avant la validation de la réquete
     *
     * @return void
     */
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
