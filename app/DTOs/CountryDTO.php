<?php

namespace App\DTOs;

use App\Custom\DbCast;

final class CountryDTO
{
    public function __construct(
        public string $dialing_code,
        public string $id,
        public string $iso2_id,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            dialing_code: $data['dialing_code'] ?? null,
            id: $data['id'] ?? null,
            iso2_id: $data['iso2_id'] ?? null,
        );
    }

    public function toDb(): ?array {
        return array_filter([
            'dialing_code' => DbCast::textLine($this->dialing_code),
            'id' => DbCast::textLine($this->id),
            'iso2_id' => DbCast::textLine($this->iso2_id),
        ]) ?: null;
    }
}
