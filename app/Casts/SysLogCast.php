<?php

namespace App\Casts;

use App\DTOs\SysLogDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class SysLogCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array {
        if (is_null($value)) return null;
        return json_decode($value, true);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string {
        if (is_null($value)) return null;
        if ($value instanceof SysLogDTO) {
            $resolvedValue = $value->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        if (is_array($value)) {
            $resolvedValue = SysLogDTO::fromArray($value)->toDb();
            return $resolvedValue ? json_encode($resolvedValue) : null;
        }
        return $value;
    }
}
