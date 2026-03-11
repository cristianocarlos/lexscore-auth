<?php

namespace App\Casts;

use App\Custom\Cast;
use App\Custom\Mask;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PtBrDateCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string {
        return Mask::date($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array|string|null {
        if (is_null($value)) return null;
        return Cast::date($value);
    }
}
