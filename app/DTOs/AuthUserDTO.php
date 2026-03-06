<?php

namespace App\DTOs;

final class AuthUserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {}
}
