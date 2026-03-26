<?php

namespace App\DTOs\ward;

use App\Custom\Cast;

final class UserPreferenceShortcutDataDTO
{
    public function __construct(
        public int $id,
        public string $label,
        public string $url_path,
        public ?string $shortcut_name,
        /** @var `TSvgMapNames`|null */
        public ?string $shortcut_icon_name,
    ) {}

    public static function fromArray(?array $data): ?self {
        return new self(
            id: $data['id'] ?? null,
            label: $data['label'] ?? null,
            url_path: $data['url_path'] ?? null,
            shortcut_name: $data['shortcut_name'] ?? null,
            shortcut_icon_name: $data['shortcut_icon_name'] ?? null,
        );
    }

    public function toForm(): ?array {
        return array_filter(array_merge((array) $this)) ?: null;
    }

    public function toDb(): ?array {
        return array_filter([
            'id' => Cast::integer($this->id),
            'label' => Cast::textLine($this->label),
            'url_path' => Cast::textLine($this->url_path),
            'shortcut_name' => Cast::textLine($this->shortcut_name),
            'shortcut_icon_name' => Cast::textLine($this->shortcut_icon_name),
        ]) ?: null;
    }

    /**
     * @return array<static>|null
     */
    public static function collectionFromArray(?array $rows): ?array {
        if (empty($rows)) return null;
        return array_map(fn ($data) => self::fromArray($data), $rows);
    }

    /**
     * @param  array<static>|null  $rows
     */
    public static function collectionToForm(?array $rows): ?array {
        if (empty($rows)) return null;
        return array_map(fn ($data) => $data?->toForm(), $rows);
    }

    /**
     * @param  array<static>|null  $rows
     */
    public static function collectionToDb(?array $rows): ?array {
        if (empty($rows)) return null;
        return array_map(fn ($data) => $data?->toDb(), $rows);
    }
}
