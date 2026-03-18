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
 * @property int $file_code Sequential code
 * @property string $file_name Name
 * @property string|null $file_path Path
 * @property int $file_size Size (bytes)
 * @property string $file_mity Mime type
 * @property string $file_daho Date hour (creation, search pourposes)
 * @property int $file_moid Id in the table of the module, e.g. dtse_code
 * @property int $file_modu Module (FK) without constraint on porpouse
 * @property int $file_type Type (type: file)
 * @property int $file_stse Storage service (type: storageService)
 * @property bool $file_tras Trashed, to be deleted on the storage service
 * @property string|null $file_data Binary data
 * @property string|null $sys_log JSON log: {
 *         insert_date_hour: timestamp,
 *         insert_who_id: number,
 *         insert_who_name: string,
 *         last_update_date_hour: timestamp,
 *         last_update_who_id: number,
 *         last_update_who_name: string
 *       }
 * @property string|null $file_tag_rows JSON tags
 * @property int|null $file_heig File height (for image)
 * @property int|null $file_widt File width (for image)
 * @property bool $file_conf Confirmed (handleUploadSuccess)
 * @property int $file_orde Order (galleries only)
 * @property int $file_stde Storage delivery (type: storageDelivery)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileConf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileDaho($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileHeig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileMity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileModu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileMoid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileOrde($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileStde($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileStse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileTagRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileTras($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereFileWidt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereSysLog($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFile {}
}

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
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property int $user_code Main sequential
 * @property string|null $user_mail E-mail
 * @property string|null $user_pass Password
 * @property int $user_stat Status (type: status)
 * @property string|null $user_pref_data
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
 * @property int|null $user_cpf CPF number
 * @property string|null $user_pers_data Personal data: {
 *   gender: number;
 *   address: AddressDTO;
 *   birth_date: string;
 *   phone_rows: Array<PhoneDTO>;
 * }
 * @property string|null $user_phot Photo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereSysLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserPersData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserPhot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserPrefData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthUser whereUserStat($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthUser {}
}

namespace App\Models\ward{
/**
 * @property int $user_code Main sequential
 * @property string|null $user_mail E-mail
 * @property string|null $user_pass Password
 * @property int $user_stat Status (type: status)
 * @property string|null $user_pref_data
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
 * @property string|null $user_cpf CPF number
 * @property array|null $user_pers_data Personal data: {
 *   gender: number;
 *   address: AddressDTO;
 *   birth_date: string;
 *   phone_rows: Array<PhoneDTO>;
 * }
 * @property string|null $user_phot Photo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ward\UserToken> $notExpiredEmailChangeTokenRelation
 * @property-read int|null $not_expired_email_change_token_relation_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereSysLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserPersData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserPhot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserPrefData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrudUser whereUserStat($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCrudUser {}
}

namespace App\Models\ward{
/**
 * @property int $menu_code Sequential code
 * @property string $menu_name Name
 * @property int|null $menu_rout RbacRoute (FK) sem constraint por causa do refatoramento action/route
 * @property int $menu_orde Order
 * @property int|null $menu_menu Menu (FK) sem constraint because chato pra caralho
 * @property array|null $menu_shcu_data Shortcut data: {icon_name: text, name: text}
 * @property-read mixed $menu_menu_desc
 * @property-read mixed $menu_rout_desc
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuOrde($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuRout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuShcuData($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMenu {}
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
 * @property int $rout_code Sequential code
 * @property string $rout_path Path exactly as declared on server (aka /api/controller/action/{id})
 * @property string|null $rout_name Name (a clear way to identification on maintenance screen)
 * @property string $rout_ctrl_path Controller path: portion before action (aka /api/controller)
 * @property int $rout_type Type (type: route)
 * @property bool $rout_lock If restrict (only sysadmin can do it)
 * @property int $rout_vers Version
 * @property int $rout_plan Plan (FK)
 * @property string|null $rout_ctrl_name Controller name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutCtrlName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutCtrlPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RbacRoute whereRoutVers($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRbacRoute {}
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
 * @property int $ustk_code Sequential code
 * @property int $ustk_user User (FK)
 * @property string $ustk_toke Reset password/Change e-mail: token
 * @property string $ustk_daho Reset password/Change e-mail: date hour for expiry control porpouses
 * @property string $ustk_mail Change e-mail: new e-mail to be updated on user when confirmed
 * @property int $ustk_type Type (type: userToken)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken notExpiredEmailChange()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken notExpiredPasswordReset()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkDaho($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkToke($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserToken whereUstkUser($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserToken {}
}

