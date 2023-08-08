<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Válida formato de tlf, debe ser ^0[0-9]*$
 */
class CustomPhoneFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^0[0-9]*$/', $value)) {
            $fail(trans('validation.custom.attribute-name.phone_format'));
        }
    }
}
