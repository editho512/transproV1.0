<?php

namespace App\Http\Requests\Maintenance;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ModifierMaintenanceRequest extends FormRequest
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
            "titre" => ["required", "min:5", "max:255", "sometimes", "unique:maintenances,titre,".$this->maintenance->id.",id"],
            "date_heure" => ["required", "date", "date_format:Y-m-d H:i:s", 'before_or_equal:' . Carbon::now('EAT')->toDateTimeString()],
            "camion_id" => ["required", "numeric", "exists:camions,id"],
            "main_oeuvre" => ["required", "numeric", "min:1", "max:999999999999"],
            "commentaire" => ["nullable", "sometimes", "min:5", "max:5000"],
            "nom_reparateur" => ["required", "sometimes", "min:2", "max:500"],
            "tel_reparateur" => ["required"],
            "adresse_reparateur" => ["required", "sometimes"],
            "pieces" => ["nullable", "sometimes"],
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