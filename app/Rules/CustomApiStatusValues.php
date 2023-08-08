<?php

namespace App\Rules;

use App\System\ApiCustomers;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Verifica que se ingresen valores aceptados para el campo api_status;
 * a la fecha 2023-07-25, todos los posibles son: 1,2,10,20,4,5,40,50,7
 */
class CustomApiStatusValues implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, ApiCustomers::apiStatusValues())) {
            $fail(trans('validation.custom.attribute-name.api_status'));
        }
    }
}
