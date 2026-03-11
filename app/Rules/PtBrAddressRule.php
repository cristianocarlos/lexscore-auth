<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as MainValidator;

class PtBrAddressRule implements ValidationRule, ValidatorAwareRule
{
    public function setValidator(MainValidator $validator): static {
        $this->mainValidator = $validator;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $attributeRules = $this->mainValidator->getRules()[$attribute] ?? [];
        $shouldValidate = in_array('nullable', $attributeRules) ? !$this->essentialEmpty($value) : true;
        if ($shouldValidate) {
            $validator = Validator::make($value, [
                'city' => 'required|integer',
                'city_desc' => 'required|string',
                'complement' => 'nullable|string',
                'line1' => 'required|string',
                'line2' => 'nullable|string',
                'number' => 'nullable|string',
                'zip_code' => ['required', new PtBrZipCodeRule],
            ]);
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $errorKeyPath => $errorMessages) {
                    $this->mainValidator->errors()->add(
                        "{$attribute}.{$errorKeyPath}",
                        implode(',', $errorMessages)
                    );
                }
            }
        }
    }

    private function essentialEmpty(array $value): bool {
        return empty($value['city_desc']) && empty($value['line1']) && empty($value['zip_code']);
    }
}
