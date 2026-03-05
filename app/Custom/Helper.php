<?php

namespace App\Custom;

class Helper
{
    /**
     * keyword arrayStripNulls; array_strip_nulls; arrayFilter
     * Resolve também os valores de cada item do array, tudo null é considerado vazio
     */
    public static function resolveArrayValue(?array $value): ?array {
        if (blank($value)) return null;
        $filteredValues = is_array($value) ? array_filter($value, function ($itemValue) {
            return !blank($itemValue);
        }) : $value;
        return empty($filteredValues) ? null : $filteredValues;
    }
}
