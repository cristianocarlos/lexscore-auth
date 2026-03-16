<?php

namespace App\Models\ward;

use App\Custom\Cast;
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

    public static function getExpiryTimestamp(int $days = -1): string {
        return Cast::timestamp(now()->addDays($days));
    }

    public static function notExpiredBuilder(): Builder {
        return static::where('ustk_daho', '>', static::getExpiryTimestamp());
    }

    public static function tokenSave(int $userId, ?string $email = null): static {
        $model = new static;
        $model->ustk_user = $userId;
        $model->ustk_daho = Cast::nowTimestamp();
        $model->ustk_toke = Str::random(60);
        $model->ustk_mail = $email;
        $model->save();
        return $model;
    }
}
