<?php

namespace App\Casts\ward;

use App\DTOs\clinic\UserPrefDataDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserPrefDataCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array {
        if (is_null($value)) return null;
        $data = json_decode($value, true);
        return UserPrefDataDTO::fromArray($data)->toForm();
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string {
        if (is_null($value)) return null;
        if ($value instanceof UserPrefDataDTO) {
            $resolvedValue = $value->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        if (is_array($value)) {
            $resolvedValue = UserPrefDataDTO::fromArray($value)->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        return $value;
    }
}
