<?php

namespace App\Models\ward;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRbacUserRole
 */
class RbacUserRole extends Model
{
    protected $table = 'admin.rbac_user_role';
    public $timestamps = false;

    // Custom column names
    protected $fillable = [
        'usro_user',
        'usro_role',
    ];
}
