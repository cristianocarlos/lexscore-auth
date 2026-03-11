<?php

namespace App\Casts\ward;

use App\DTOs\ward\UserPersDataDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserPersDataCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array {
        if (is_null($value)) return null;
        return json_decode($value, true);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string {
        if (is_null($value)) return null;
        if ($value instanceof UserPersDataDTO) {
            $resolvedValue = $value->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        if (is_array($value)) {
            $resolvedValue = UserPersDataDTO::fromArray($value)->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        return $value;
    }
}
