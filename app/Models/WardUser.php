<?php

namespace App\Models;

use App\Enums\PhpGenEnum;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @mixin IdeHelperWardUser
 */
class WardUser extends Authenticatable implements JWTSubject
{
    protected $table = 'admin.user';
    protected $primaryKey = 'user_code';
    public $timestamps = false;
    protected $casts = [
        'sys_log' => AsArrayObject::class,
        'user_pref_data' => AsArrayObject::class,
        'user_pass' => 'hashed',
    ];
    protected $attributes = [
        'user_stat' => PhpGenEnum::STATUS_OK->value,
    ];

    // Custom column names
    protected $fillable = [
        'user_mail',
        'user_pass',
        'user_stat',
        //
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
        // return response()->json(CustomUser::find(2));
        // If password is stored as MD5 (32 chars hex)
        if (mb_strlen($this->user_pass) === 32 && ctype_xdigit($this->user_pass)) {
            return md5($plainPassword) === $this->user_pass;
        }
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
            'user_stat' => PhpGenEnum::STATUS_OK->value,
        ])->first();
    }

    public function requestFill(): void {
        $this->user_mail = request()->input('email');
        $this->user_stat = request()->input('status_id');
        $this->user_code = request()->input('id');
        if (request()->input('password')) {
            // Uma vez existente, não pode mais ser vazio, apenas uma nova senha
            $this->user_pass = request()->input('password');
        }
    }

    public function getNextSequence(): ?int {
        $rows = DB::select("SELECT NEXTVAL('public.main_code_seq')");
        if (!empty($rows)) return $rows[0]->nextval;
        return null;
    }
}
