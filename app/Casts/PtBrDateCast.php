<?php

namespace App\Casts;

use App\Custom\DbCast;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PtBrDateCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array|string|null {
        if (is_null($value)) return null;
        return DbCast::date($value);
    }
}
