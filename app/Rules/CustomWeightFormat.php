<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida el formato de peso, debe ser 15,6.
 */
class CustomWeightFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{1,9}(\.\d{1,6})?$/', $value)) {
            $fail(trans('validation.custom.attribute-name.weight_format'));
        }
    }
}
