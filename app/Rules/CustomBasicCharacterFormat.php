<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida el formato de carácteres a usar, debe ser a-zA-Z0-9.
 */
class CustomBasicCharacterFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z0-9]*$/', $value)) {
            $fail(trans('validation.custom.attribute-name.basic_character_format'));
        }
    }
}
