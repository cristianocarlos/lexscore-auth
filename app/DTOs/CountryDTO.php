<?php

namespace App\DTOs;

use App\Custom\CastHelper;

final class CountryDTO
{
    public function __construct(
        public string $dialing_code,
        public string $id,
        public string $iso2_id,
    ) {}

    public static function fromArray(?array $data): ?self {
        if (empty($data)) return null;
        if (empty(array_filter($data))) return null;
        return new self(
            dialing_code: $data['dialing_code'] ?? null,
            id: $data['id'] ?? null,
            iso2_id: $data['iso2_id'] ?? null,
        );
    }

    public function toDb(): ?array {
        return array_filter([
            'dialing_code' => CastHelper::textLine($this->dialing_code),
            'id' => CastHelper::textLine($this->id),
            'iso2_id' => CastHelper::textLine($this->iso2_id),
        ]) ?: null;
    }
}
