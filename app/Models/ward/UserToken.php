<?php

namespace App\Models\ward;

use App\Custom\Cast;
use App\Mail\EmailChangeMailable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
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
        return static::where('ustk_daho', '>', UserToken::getExpiryTimestamp());
    }

    public static function tokenSaveAndMail(int $userId, ?string $email): static {
        $model = new static;
        $model->ustk_user = $userId;
        $model->ustk_daho = Cast::nowTimestamp();
        $model->ustk_toke = Str::random(60);
        $model->ustk_mail = $email;
        $model->save();
        $mailable = new EmailChangeMailable([
            'email' => $model->ustk_mail,
            'link' => "http://ward.lexscore-com.test/email-change-confirm/{$model->ustk_toke}", // TODO: hardcoded
            'subject' => 'Agora vai',
        ]);
        Mail::to($model->ustk_mail)->send($mailable);
        return $model;
    }
}
