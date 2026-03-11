<?php

namespace App\DTOs\ward;

use App\Custom\DbCast;
use App\DTOs\AddressDTO;
use App\DTOs\PhoneDTO;
use Carbon\Carbon;

final class UserPersDataDTO
{
    public function __construct(
        public ?AddressDTO $address,
        public ?string $birth_date,
        public ?int $gender,
        /** @var array<PhoneDTO>|null */
        public ?array $phone_rows,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            address: AddressDTO::fromArray($data['address'] ?? null),
            birth_date: $data['birth_date'] ?? null,
            gender: $data['gender'] ?? null,
            phone_rows: PhoneDTO::collectionFromArray($data['phone_rows'] ?? null),
        );
    }

    public function toForm(): ?array {
        return array_filter(array_merge((array) $this, [
            'birth_date' => Carbon::parse($this->birth_date)->format('d/m/Y'),
            'phone_rows' => PhoneDTO::collectionToForm($this->phone_rows),
        ])) ?: null;
    }

    public function toDb(): ?array {
        return array_filter([
            'address' => $this->address?->toDb(),
            'birth_date' => DbCast::date($this->birth_date),
            'gender' => DbCast::integer($this->gender),
            'phone_rows' => PhoneDTO::collectionToDb($this->phone_rows),
        ]) ?: null;
    }
}
