<?php

namespace App\Models;

use App\Casts\SysLogCast;
use App\Traits\ModelSysLogTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperWardRole
 */
class WardRole extends Model
{
    use ModelSysLogTrait;

    protected $table = 'admin.rbac_role';
    protected $primaryKey = 'role_code';
    public $timestamps = false;
    protected $casts = [
        'sys_log' => SysLogCast::class,
    ];

    // Custom column names
    protected $fillable = [
        'role_name',
        'role_desc',
        'sys_log',
    ];
}
