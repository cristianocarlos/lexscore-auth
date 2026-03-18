<?php

namespace App\Models\ward;

use App\Custom\Cast;
use App\Enums\YiiEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperUserToken
 */
class UserToken extends Model
{
    protected $table = 'admin.user_token';
    protected $primaryKey = 'ustk_code';
    public $timestamps = false;
    protected $casts = [];
    protected $attributes = [];
    protected $fillable = [
        'ustk_toke',
        'ustk_daho',
        'ustk_mail',
    ];
    protected $hidden = [];

    #[Scope]
    protected function notExpiredEmailChange(Builder $query): void {
        $query->where('ustk_daho', '>', static::getExpiryTimestamp())
            ->where('ustk_type', YiiEnum::USER_TOKEN_EMAIL_CHANGE->value);
    }

    #[Scope]
    protected function notExpiredPasswordReset(Builder $query): void {
        $query->where('ustk_daho', '>', static::getExpiryTimestamp())
            ->where('ustk_type', YiiEnum::USER_TOKEN_PASSWORD_RESET->value);
    }

    public static function getExpiryTimestamp(int $days = -1): string {
        return Cast::timestamp(now()->addDays($days));
    }

    public static function tokenSave(int $userId, string $email, int $typeId): static {
        $model = new static;
        $model->ustk_user = $userId;
        $model->ustk_daho = Cast::nowTimestamp();
        $model->ustk_toke = Str::random(60);
        $model->ustk_mail = $email;
        $model->ustk_type = $typeId;
        $model->save();
        return $model;
    }
}
