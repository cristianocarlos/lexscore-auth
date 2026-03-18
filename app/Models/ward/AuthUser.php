<?php

namespace App\Models\ward;

use App\Casts\SysLogCast;
use App\Enums\YiiEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @mixin IdeHelperUser
 */
class AuthUser extends Authenticatable implements JWTSubject
{
    const string GUARD = 'ward';

    protected $table = 'admin.user';
    protected $primaryKey = 'user_code';
    public $timestamps = false;
    protected $casts = [
        'sys_log' => SysLogCast::class,
        'user_pass' => 'hashed',
    ];
    protected $fillable = [
        'user_mail',
        'user_pass',
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

    public function resolveSysLog(array $newProps): void {
        $this->sys_log = array_merge((array) $this->sys_log, $newProps);
    }
}
