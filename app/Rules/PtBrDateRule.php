<?php

namespace App\Rules;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PtBrDateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $value)) {
            $fail('The :attribute must be in the format XX/XX/XXXX.');
        } elseif (!$this->isValid($value)) {
            $fail('The :attribute is invalid.');
        }
    }

    public function isValid(string $value, string $format = 'd/m/Y'): bool {
        try {
            Carbon::createFromFormat($format, $value)->format($format);
            return true;
        } catch (InvalidFormatException $e) {
            // If an exception is caught, the date string or format is invalid
            return false;
        }
    }
}
