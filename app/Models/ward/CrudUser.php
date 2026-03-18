<?php

namespace App\Models\ward;

use App\Casts\Base64FileCast;
use App\Casts\CpfCast;
use App\Casts\SysLogCast;
use App\Casts\ward\UserPersDataCast;
use App\Custom\Cast;
use App\Enums\YiiEnum;
use App\Observers\SysLogObserver;
use App\Observers\ward\CrudUserObserver;
use App\Scopes\ward\CrudUserScope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperUser
 */
#[ScopedBy([CrudUserScope::class])]
#[ObservedBy([CrudUserObserver::class])]
#[ObservedBy([SysLogObserver::class])]
class CrudUser extends Model
{
    protected $table = 'admin.user';
    protected $primaryKey = 'user_code';
    public $timestamps = false;
    protected $casts = [
        'sys_log' => SysLogCast::class,
        'user_cpf' => CpfCast::class,
        'user_pass' => 'hashed',
        'user_pers_data' => UserPersDataCast::class,
        'user_phot' => Base64FileCast::class,
    ];
    protected $attributes = [
        'user_stat' => YiiEnum::STATUS_OK->value,
    ];
    protected $fillable = [
        'user_cpf',
        'user_mail',
        'user_name',
        'user_pass',
        'user_phot',
        'user_pers_data',
        'user_pref_data',
        'user_stat',
        'sys_log',
    ];
    protected $hidden = [
        'user_pass',
    ];

    public function notExpiredEmailChangeTokenRelation(): HasMany {
        return $this->hasMany(UserToken::class, 'ustk_user')->notExpiredEmailChange();
    }

    public function getNextSequence(): ?int {
        $rows = DB::select("SELECT NEXTVAL('public.main_code_seq')");
        if (!empty($rows)) return $rows[0]->nextval;
        return null;
    }

    public function resolveAttributes(Request $request): void {
        $this->user_code = $request->input('id');
        $this->user_cpf = $request->input('cpf');
        $this->user_mail = $request->input('email');
        $this->user_name = $request->input('name');
        $this->user_pers_data = $request->input('personal_data');
        $this->user_phot = $request->input('photo');
        $this->user_stat = $request->input('status_id');
        $this->resolvePasswordAttributes($request);
    }

    public function resolvePasswordAttributes(Request $request): void {
        if ($request->input('password')) {
            // Uma vez existente, não pode mais ser vazio, apenas uma nova senha
            $this->user_pass = $request->input('password');
            $this->resolveSysLog([
                'password_last_update_date_hour' => Cast::nowTimestamp(),
            ]);
        }
    }

    public function resolveSysLog(array $newProps): void {
        $this->sys_log = array_merge((array) $this->sys_log, $newProps);
    }
}
