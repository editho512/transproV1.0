<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Remorque as RemorqueModel;

class Remorque implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
  
        $valid = is_array($value);

        if($valid){
            foreach($value as $val){
                $valid = RemorqueModel::find($val) === null ? false : $valid;               
            }
        }

        
        return $valid;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Le remorque n'existe pas";
    }
}
