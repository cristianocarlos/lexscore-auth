<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Base64FileCast implements CastsAttributes
{
    const string DATA_URI_PREFIX = 'data:image/jpeg;base64,';

    public function get(Model $model, string $key, mixed $value, array $attributes): ?string {
        if (is_null($value)) return null;
        if (is_string($value)) return $value;
        return static::DATA_URI_PREFIX . base64_encode(hex2bin(stream_get_contents($value)));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string {
        if (is_null($value)) return null;
        return bin2hex(base64_decode(str_replace(static::DATA_URI_PREFIX, '', $value)));
    }
}
