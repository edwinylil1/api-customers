<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida el formato de moneda, debe ser 20,4.
 */
class CustomCurrencyFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{1,16}(\.\d{1,4})?$/', $value)) {
            $fail(trans('validation.custom.attribute-name.currency_format'));
        }
    }

}
