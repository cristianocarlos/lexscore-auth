<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResponseResource extends JsonResource
{
    private string $message;
    private bool $success;

    public function __construct($resource, $message = '=^.^=', $success = true) {
        parent::__construct($resource);
        $this->message = $message;
        $this->success = $success;
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
