<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResponseResource extends JsonResource
{
    private string $message;
    private bool $success;
    private array $errors;

    public function __construct($resource, $message = '=^.^=', $success = true, $errors = []) {
        parent::__construct($resource);
        $this->message = $message;
        $this->success = empty($errors) ? $success : false;
        $this->errors = $errors;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'additional' => $this->whenNotNull($this->additional ?: null),
            'content' => $this->whenNotNull($this->resource),
            'errors' => $this->whenNotNull($this->errors ?: null),
            'message' => $this->getMessage(),
            'success' => $this->success,
        ];
    }

    public function getMessage(): string {
        return match ($this->message) {
            'create' => 'Registro criado com sucesso!',
            'delete' => 'Registro excluído com sucesso!',
            'update' => 'Registro atualizado com sucesso!',
            default => $this->message,
        };
    }
}
