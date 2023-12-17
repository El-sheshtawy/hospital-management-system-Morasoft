<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected string $message = 'This word is forbidden for :attribute';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(strtolower($value), ['killer', 'killing', 'fucking'])) {
            $fail('This word '.'"' ."{$value}".'"'.' is forbidden for :attribute');
        }
    }
}
