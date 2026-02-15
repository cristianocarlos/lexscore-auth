<?php

namespace App\Models\misc;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperType
 */
class Type extends Model
{
    protected $table = 'misc.type';
    protected $primaryKey = 'type_code';

    public static function getName(?int $id) {
        if (!$id) return null;
        return static::where('type_code', $id)->value('type_name');
    }
}
