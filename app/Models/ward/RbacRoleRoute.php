<?php

namespace App\Models\ward;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRbacRoleRoute
 */
class RbacRoleRoute extends Model
{
    protected $table = 'admin.rbac_role_route';
    public $timestamps = false;
    protected $fillable = [
        'roro_role',
        'roro_rout',
    ];
}
