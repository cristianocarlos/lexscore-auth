<?php

namespace App\Http\Resources\ward\user;

use App\Models\ward\CrudUser as WardCrudUser;
use App\Models\ward\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WardCrudUser
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->user_code ?: $this->getNextSequence(),
            'cpf' => $this->whenNotNull($this->user_cpf),
            'email' => $this->whenNotNull($this->user_mail),
            'has_password' => (bool) $this->user_pass,
            'name' => $this->user_name,
            'pending_email' => $this->whenNotNull($this->notExpiredEmailChangeTokenRelation()->first()?->ustk_mail),
            'personal_data' => $this->whenNotNull($this->user_pers_data),
            'photo' => $this->whenNotNull($this->user_phot),
            'preferences' => $this->whenNotNull($this->user_pref_data),
            'status_id' => $this->user_stat,
            'status_name' => Type::getName($this->user_stat),
            'sys_log' => $this->sys_log ?: literal(),
        ];
    }
}
