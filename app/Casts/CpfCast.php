<?php

namespace App\Casts;

use App\Custom\DbCast;
use App\Custom\Mask;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CpfCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string {
        return Mask::formatCpf($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array|string|null {
        if (is_null($value)) return null;
        return DbCast::stripNonNumber($value);
    }
}
