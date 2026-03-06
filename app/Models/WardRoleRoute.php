<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperWardRole
 */
class WardRoleRoute extends Model
{
    protected $table = 'admin.rbac_role_route';
    protected $primaryKey = 'roro_code';
    public $timestamps = false;

    // Custom column names
    protected $fillable = [
        'roro_role',
        'roro_rout',
    ];
}
