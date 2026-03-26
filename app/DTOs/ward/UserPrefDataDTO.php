<?php

namespace App\DTOs\ward;

use App\Custom\Cast;

final class UserPrefDataDTO
{
    public function __construct(
        public ?int $idle_minutes,
        /** @var array<UserPreferenceShortcutDataDTO>|null */
        public ?array $shortcuts,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            idle_minutes: $data['idle_minutes'] ?? null,
            shortcuts: UserPreferenceShortcutDataDTO::collectionFromArray($data['shortcuts'] ?? null),
        );
    }

    public function toForm(): ?array {
        return array_filter(array_merge((array) $this, [
            'idle_minutes' => $this->idle_minutes,
            'shortcuts' => UserPreferenceShortcutDataDTO::collectionToForm($this->shortcuts),
        ])) ?: null;
    }

    public function toDb(): ?array {
        return array_filter([
            'idle_minutes' => Cast::integer($this->idle_minutes),
            'shortcuts' => UserPreferenceShortcutDataDTO::collectionToDb($this->shortcuts),
        ]) ?: null;
    }
}
