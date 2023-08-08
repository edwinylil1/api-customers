<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida que la tasa aplicada sea 16,6.
 */
class CustomRateFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{1,10}(\.\d{1,6})?$/', $value)) {
            $fail(trans('validation.custom.attribute-name.rate_format'));
        }
    }
}
