<?php

namespace App\Models\ward;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRbacRoute
 */
class RbacRoute extends Model
{
    protected $table = 'admin.rbac_route';
    protected $primaryKey = 'rout_code';
    public $timestamps = false;
    protected $casts = [];
    protected $fillable = [];

    public static function getName(?int $id) {
        if (!$id) return null;
        return static::where('rout_code', $id)->value('rout_path');
    }
}
