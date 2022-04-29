<?php

namespace App\Rules;

use App\Models\Trajet;
use Illuminate\Contracts\Validation\Rule;

class BonEnlevement implements Rule
{
    protected $etat;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->etat = $status;
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
        return !in_array($this->etat, [Trajet::getEtat(2)]) || ($value != null && strlen($value) > 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
