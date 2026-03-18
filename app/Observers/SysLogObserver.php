<?php

namespace App\Observers;

use App\Custom\Cast;
use App\Models\ward\AuthUser as ClinicAuthUser;
use Illuminate\Database\Eloquent\Model;

class SysLogObserver
{
    private function getAuthUserModel(Model $model): ClinicAuthUser {
        if (!array_key_exists('sys_log', $model->getCasts())) {
            // Não precisa estar no fillable, mas precisa estar no casts
            throw new \Exception('Para usar o sys_log é necessário configura-lo no casts do model (\'sys_log\' => SysLogCast::class)');
        }
        /** @var ClinicAuthUser $userModel */
        $userModel = auth(ClinicAuthUser::GUARD)->user();
        return $userModel;
    }

    public function creating(Model $model): void {
        $userModel = $this->getAuthUserModel($model);
        $model->sys_log = [
            'insert_date_hour' => Cast::nowTimestamp(),
            'insert_user_id' => $userModel->user_code,
            'insert_user_name' => $userModel->user_name,
            'tracking_remote_addr' => request()->ip(),
            'tracking_user_agent' => request()->userAgent(),
        ];
    }

    public function updating(Model $model): void {
        $userModel = $this->getAuthUserModel($model);
        $model->sys_log = array_merge($model->sys_log ?: [], [
            'update_last_date_hour' => Cast::nowTimestamp(),
            'update_last_user_id' => $userModel->user_code,
            'update_last_user_name' => $userModel->user_name,
            'tracking_remote_addr' => request()->ip(),
            'tracking_user_agent' => request()->userAgent(),
        ]);
    }
}
