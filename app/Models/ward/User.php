<?php

namespace App\Models\ward;

use App\Casts\Base64FileCast;
use App\Casts\CpfCast;
use App\Casts\SysLogCast;
use App\Casts\ward\UserPersDataCast;
use App\Custom\Cast;
use App\Enums\YiiEnum;
use App\Traits\ModelSysLogTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements JWTSubject
{
    use ModelSysLogTrait;

    const string AUTH_GUARD = 'ward';

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

    public function getAuthPassword(): string {
        return $this->user_pass;
    }

    // Override the default password field name
    public function getAuthPasswordName(): string {
        return 'user_pass';
    }

    public function validatePassword($plainPassword): string {
        return Hash::check($plainPassword, $this->user_pass);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array {
        return [
            'name' => $this->user_mail,
            'email' => $this->user_mail,
        ];
    }

    public static function findByUsername(string $username): ?static {
        $columnName = str_contains($username, '@') ? 'user_mail' : 'user_code';
        return static::where([
            $columnName => $username,
            'user_stat' => YiiEnum::STATUS_OK->value,
        ])->first();
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

    public function getNextSequence(): ?int {
        $rows = DB::select("SELECT NEXTVAL('public.main_code_seq')");
        if (!empty($rows)) return $rows[0]->nextval;
        return null;
    }

    public function resolveSysLog(array $newProps): void {
        $this->sys_log = array_merge((array) $this->sys_log, $newProps);
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

    public function emailChangeTokenRelation(): HasMany {
        return $this->hasMany(UserToken::class, 'ustk_user')
            ->whereNotNull('ustk_mail')
            ->where('ustk_daho', '>', UserToken::getExpiryTimestamp());
    }
}
