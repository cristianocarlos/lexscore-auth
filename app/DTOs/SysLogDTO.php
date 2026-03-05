<?php

namespace App\DTOs;

use App\Custom\Helper;

final class SysLogDTO
{
    public function __construct(
        public ?string $insert_date_hour,
        public ?int $insert_user_id,
        public ?string $insert_user_name,
        public ?int $login_count,
        public ?string $login_last_date_hour,
        public ?int $login_last_user_id,
        public ?string $login_last_user_name,
        public ?string $password_last_update_date_hour,
        public ?string $tracking_remote_addr,
        public ?string $tracking_user_agent,
        public ?string $update_last_date_hour,
        public ?int $update_last_user_id,
        public ?string $update_last_user_name,
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            insert_date_hour: $data['insert_date_hour'] ?? null,
            insert_user_id: $data['insert_user_id'] ?? null,
            insert_user_name: $data['insert_user_name'] ?? null,
            login_count: $data['login_count'] ?? null,
            login_last_date_hour: $data['login_last_date_hour'] ?? null,
            login_last_user_id: $data['login_last_user_id'] ?? null,
            login_last_user_name: $data['login_last_user_name'] ?? null,
            password_last_update_date_hour: $data['password_last_update_date_hour'] ?? null,
            tracking_remote_addr: $data['tracking_remote_addr'] ?? null,
            tracking_user_agent: $data['tracking_user_agent'] ?? null,
            update_last_date_hour: $data['update_last_date_hour'] ?? null,
            update_last_user_id: $data['update_last_user_id'] ?? null,
            update_last_user_name: $data['update_last_user_name'] ?? null,
        );
    }

    public function toDb(): ?array {
        return Helper::resolveArrayValue((array) $this);
    }
}
