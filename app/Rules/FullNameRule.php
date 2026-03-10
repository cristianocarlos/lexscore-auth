<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FullNameRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!preg_match('/^[\pL\s]+$/u', $value)) {
            $fail('The :attribute allows only letters and spaces');
        }
        if (!preg_match('/\s/', $value)) {
            $fail('The :attribute requires at least one space between names');
        }
    }
}
