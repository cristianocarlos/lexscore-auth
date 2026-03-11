<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class RecursiveTreeRule implements ValidationRule
{
    /**
     * The validation rules for each node
     */
    protected array $nodeRules;

    /**
     * Maximum recursion depth to prevent stack overflows
     */
    protected int $maxDepth;

    /**
     * Create a new rule instance.
     */
    public function __construct(array $nodeRules, int $maxDepth = 10) {
        $this->nodeRules = $nodeRules;
        $this->maxDepth = $maxDepth;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $items = $value;
        foreach ($items as $index => $item) {
            $basePath = "items.{$index}"; // TODO: como saber o nome do atributo items? usar no resto todo
            $this->validateNode($item, $basePath, 0, $fail);
        }
    }

    /**
     * Recursively validate a node and its children
     */
    protected function validateNode(array $node, string $basePath, int $depth, Closure $fail): bool {
        if ($depth > $this->maxDepth) {
            $fail("{$basePath} exceeds maximum recursion depth of {$this->maxDepth}.");
            return false;
        }

        $validator = Validator::make($node, $this->nodeRules);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $errorKeyPath => $errorMessages) {
                $errorMessage = implode(',', $errorMessages);
                $fail("{$basePath}.{$errorKeyPath}: {$errorMessage}");
            }
            return false;
        }

        // Recursively validate children if they exist
        if (!empty($node['items']) && is_array($node['items'])) {
            foreach ($node['items'] as $index => $child) {
                if (!$this->validateNode($child, "{$basePath}.items.{$index}", $depth + 1, $fail)) {
                    break;
                }
            }
        }

        return true;
    }
}
