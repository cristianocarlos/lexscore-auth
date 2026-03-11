<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as MainValidator;

class PhoneRowsRule implements ValidationRule, ValidatorAwareRule
{
    public function setValidator(MainValidator $validator): static {
        $this->mainValidator = $validator;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $attributeRules = $this->mainValidator->getRules()[$attribute] ?? [];
        $shouldValidate = in_array('nullable', $attributeRules) ? !$this->essentialEmpty($value) : true;
        if ($shouldValidate) {
            foreach ($value as $index => $itemValue) {
                $this->itemValidate($attribute, $itemValue, $index);
            }
        }
    }

    private function itemValidate(string $attribute, array $itemValue, int $index): void {
        $shouldValidate = !$this->itemEssentialEmpty($itemValue) || $index === 0; // Primeiro precisa validar sempre
        if ($shouldValidate) {
            $validator = Validator::make($itemValue, [
                'extension' => 'nullable|string',
                'is_main' => 'integer',
                'is_restrict' => 'integer',
                'number' => 'required|string',
                'type' => 'nullable|integer',
                'type_desc' => 'nullable|string',
            ]);
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $errorKeyPath => $errorMessages) {
                    $this->mainValidator->errors()->add(
                        "{$attribute}.{$index}.{$errorKeyPath}",
                        implode(',', $errorMessages)
                    );
                }
            }
        }
    }

    private function essentialEmpty(array $value): bool {
        return array_all($value, fn ($itemValue) => $this->itemEssentialEmpty($itemValue));
    }

    private function itemEssentialEmpty(array $itemValue): bool {
        return empty($itemValue['number']) && empty($itemValue['type_desc']);
    }
}
