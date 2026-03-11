<?php

namespace App\DTOs;

use App\Custom\DbCast;
use App\Custom\Mask;

final class AddressDTO
{
    public function __construct(
        public int $city,
        public string $city_desc,
        public ?string $complement,
        public string $line1,
        public ?string $line2,
        public ?string $number,
        public ?string $zip_code,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            city: $data['city'] ?? null,
            city_desc: $data['city_desc'] ?? null,
            complement: $data['complement'] ?? null,
            line1: $data['line1'] ?? null,
            line2: $data['line2'] ?? null,
            number: $data['number'] ?? null,
            zip_code: $data['zip_code'] ?? null,
        );
    }

    public function toForm(): ?array {
        return array_filter(array_merge((array) $this, [
            'zip_code' => Mask::formatZipCode($this->zip_code),
        ])) ?: null;
    }

    public function toDb(): ?array {
        return array_filter([
            'city' => DbCast::integer($this->city),
            'city_desc' => DbCast::textLine($this->city_desc),
            'complement' => DbCast::textLine($this->complement),
            'line1' => DbCast::textLine($this->line1),
            'line2' => DbCast::textLine($this->line2),
            'number' => DbCast::textLine($this->number),
            'zip_code' => DbCast::stripNonNumber($this->zip_code),
        ]) ?: null;
    }
}
