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
 * @property int $type_code Code
 * @property string $type_name Name
 * @property string $type_flag Flag
 * @property string $type_cons Constant
 * @property string|null $type_name_en Name (en)
 * @property int $type_orde Order
 * @property string|null $type_name_es Name (es)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeCons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeNameEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Type whereTypeOrde($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperType {}
}

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

namespace App\Models\ward{
/**
 * @property int $role_code Main sequential code
 * @property string $role_name Name
 * @property int|null $role_user User (FK) every user is also a role
 * @property string|null $role_desc Description
 * @property int $role_shty Sharing type (type: sharing)
 * @property array|null $sys_log JSON log: {
 *         insert_date_hour: timestamp,
 *         insert_who_id: number,
 *         insert_who_name: string,
 *         last_update_date_hour: timestamp,
 *         last_update_who_id: number,
 *         last_update_who_name: string
 *       }
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereRoleCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereRoleDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereRoleShty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereRoleUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRole whereSysLog($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRbacRole {}
}

namespace App\Models\ward{
/**
 * @property int $roro_role RbacRole (FK)
 * @property int $roro_rout RbacRoute (FK)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoleRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoleRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoleRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoleRoute whereRoroRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoleRoute whereRoroRout($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRbacRoleRoute {}
}

namespace App\Models\ward{
/**
 * @property int $usro_user User (FK)
 * @property int $usro_role RbacRole (FK)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacUserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacUserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacUserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacUserRole whereUsroRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacUserRole whereUsroUser($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRbacUserRole {}
}

namespace App\Models\ward{
/**
 * @property int $user_code Main sequential
 * @property string|null $user_mail E-mail
 * @property string|null $user_pass Password
 * @property int $user_stat Status (type: status)
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed>|null $user_pref_data
 * @property array|null $sys_log JSON log: {
 *         insert_date_hour: timestamp,
 *         insert_who_id: number,
 *         insert_who_name: string,
 *         last_login_date_hour: timestamp,
 *         last_update_date_hour: timestamp,
 *         last_update_who_id: number,
 *         last_update_who_name: string,
 *         login_count: number
 *       }
 * @property string $user_name Name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSysLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserPrefData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserStat($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

