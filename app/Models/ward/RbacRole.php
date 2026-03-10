<?php

namespace App\Models\ward;

use App\Casts\SysLogCast;
use App\Traits\ModelSysLogTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @mixin IdeHelperRbacRole
 */
class RbacRole extends Model
{
    use ModelSysLogTrait;

    protected $table = 'admin.rbac_role';
    protected $primaryKey = 'role_code';
    public $timestamps = false;
    protected $casts = [
        'sys_log' => SysLogCast::class,
    ];
    protected $fillable = [
        'role_name',
        'role_desc',
        'sys_log',
    ];

    public function resolveAttributes(Request $request): void {
        $this->role_name = $request->post('name');
        $this->role_desc = $request->post('description');
    }

    public function routeAssignmentSave(?array $values): void {
        RbacRoleRoute::where('roro_role', $this->role_code)->delete();
        if (empty($values)) return;
        $batch = [];
        foreach ($values as $value) {
            $batch[] = ['roro_role' => $this->role_code, 'roro_rout' => $value];
        }
        RbacRoleRoute::insert($batch);
    }

    public function roleAssignmentSave(?array $values): void {
        RbacUserRole::where('usro_user', $this->role_code)->delete();
        if (empty($values)) return;
        $batch = [];
        foreach ($values as $value) {
            $batch[] = ['usro_user' => $this->role_code, 'usro_role' => $value];
        }
        RbacUserRole::insert($batch);
    }
}
