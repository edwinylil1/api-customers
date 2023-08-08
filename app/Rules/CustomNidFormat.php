<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Formato de nid V00000
 */
class CustomNidFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z][0-9]*$/', $value)) {
            $fail(trans('validation.custom.attribute-name.nid_format'));
        }
    }
}
