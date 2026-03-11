<?php

namespace App\DTOs;

use App\Custom\DbCast;

final class PhoneDTO
{
    public function __construct(
        public ?CountryDTO $country_data,
        public int $id,
        public ?bool $main,
        public string $number,
        public ?int $type,
        public ?string $type_desc,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            country_data: CountryDTO::fromArray($data['country_data'] ?? null),
            id: $data['id'] ?? null,
            main: $data['main'] ?? null,
            number: $data['number'] ?? null,
            type: $data['type'] ?? null,
            type_desc: $data['type_desc'] ?? null,
        );
    }

    public function toDb(): ?array {
        return array_filter([
            'country_data' => $this->country_data?->toDb(),
            'id' => DbCast::integer($this->id),
            'main' => DbCast::boolTrueOnly($this->main),
            'number' => DbCast::textLine($this->number),
            'type' => DbCast::integer($this->type),
            'type_desc' => DbCast::textLine($this->type_desc),
        ]) ?: null;
    }

    /**
     * @return array<PhoneDTO>|null
     */
    public static function collectionFromArray(?array $rows): ?array {
        if (empty($rows)) return null;
        return array_map(fn ($data) => self::fromArray($data), $rows);
    }

    /**
     * @param  array<PhoneDTO>|null  $rows
     */
    public static function collectionToDb(?array $rows): ?array {
        if (empty($rows)) return null;
        return array_map(fn ($data) => $data?->toDb(), $rows);
    }
}
