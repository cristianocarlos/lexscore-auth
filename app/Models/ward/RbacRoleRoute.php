<?php

namespace App\Models\ward;

use App\Models\IdeHelperWardRole;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRbacRoleRoute
 */
class RbacRoleRoute extends Model
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
