<?php

namespace App\DTOs\ward;

use App\Custom\Cast;

final class MenuShcuDataDTO
{
    public function __construct(
        public ?string $name,
        public ?string $icon_name,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            name: $data['name'] ?? null,
            icon_name: $data['icon_name'] ?? null,
        );
    }

    public function toDb(): ?array {
        return array_filter([
            'name' => Cast::textLine($this->name),
            'icon_name' => Cast::textLine($this->icon_name),
        ]) ?: null;
    }
}
