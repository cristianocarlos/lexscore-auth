<?php

namespace App\Traits;

trait ModelSysLogTrait
{
    protected static function booted(): void {
        parent::boot();
        static::creating(function ($model) {
            /** @var static $model */
            $model->resolveSysLogAttribute();
        });
        static::updating(function ($model) {
            /** @var static $model */
            $model->resolveSysLogAttribute();
        });
    }

    private function resolveSysLogAttribute(): void {
        if (!array_key_exists('sys_log', $this->getCasts())) {
            // Não precisa estar no fillable, mas precisa estar no casts
            throw new \Exception('Para usar o sys_log é necessário configura-la no casts do model (\'sys_log\' => SysLogCast::class)');
        }
        $authUser = \App\Custom\JwtHelper::getAuthUser();
        if ($this->exists) {
            $this->sys_log = array_merge($this->sys_log ?: [], [
                'update_last_date_hour' => now()->format('Y-m-d H:i:sT'),
                'update_last_user_id' => $authUser?->id,
                'update_last_user_name' => $authUser?->name,
                'tracking_remote_addr' => request()->ip(),
                'tracking_user_agent' => request()->userAgent(),
            ]);
            return;
        }
        $this->sys_log = [
            'insert_date_hour' => now()->format('Y-m-d H:i:sT'),
            'insert_user_id' => $authUser?->id,
            'insert_user_name' => $authUser?->name,
            'tracking_remote_addr' => request()->ip(),
            'tracking_user_agent' => request()->userAgent(),
        ];
    }
}
