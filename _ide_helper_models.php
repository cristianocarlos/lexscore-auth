<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property int $user_code Main sequential
 * @property string|null $user_mail E-mail
 * @property string|null $user_pass Password
 * @property int $user_stat Status (type: status)
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed>|null $user_pref_data
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed>|null $sys_log JSON log: {
 *         insert_date_hour: timestamp,
 *         insert_who_id: number,
 *         insert_who_name: string,
 *         last_login_date_hour: timestamp,
 *         last_update_date_hour: timestamp,
 *         last_update_who_id: number,
 *         last_update_who_name: string,
 *         login_count: number
 *       }
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereSysLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereUserMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereUserPrefData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WardUser whereUserStat($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWardUser {}
}

