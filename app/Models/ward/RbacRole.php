<?php

namespace App\Models\ward;

use App\Casts\SysLogCast;
use App\Observers\SysLogObserver;
use App\Observers\ward\RbacRoleObserver;
use App\Scopes\ward\RbacRoleScope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @mixin IdeHelperRbacRole
 */
#[ScopedBy([RbacRoleScope::class])]
#[ObservedBy([RbacRoleObserver::class])]
#[ObservedBy([SysLogObserver::class])]
class RbacRole extends Model
{
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
        $this->role_name = $request->input('name');
        $this->role_desc = $request->input('description');
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

    public static function roleAssignmentSave(?array $values, int $userId): void {
        RbacUserRole::where('usro_user', $userId)
            ->whereRaw('usro_user != usro_role') // A própria role precisa estar sempre atribuída
            ->delete();
        if (empty($values)) return;
        $batch = [];
        foreach ($values as $value) {
            $batch[] = ['usro_user' => $userId, 'usro_role' => $value];
        }
        RbacUserRole::insert($batch);
    }
}
