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

    public function permissionsSave(?array $values): void {
        WardRoleRoute::where('roro_role', $this->role_code)->delete();
        if (empty($values)) return;
        $batch = [];
        foreach ($values as $value) {
            $batch[] = ['roro_role' => $this->role_code, 'roro_rout' => $value];
        }
        WardRoleRoute::insert($batch);
    }
}
