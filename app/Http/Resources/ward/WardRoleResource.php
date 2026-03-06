<?php

namespace App\Http\Resources\ward;

use App\Models\WardRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WardRole
 */
class WardRoleResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->role_code,
            'name' => $this->role_name,
            'description' => $this->whenNotNull($this->role_desc),
            'sys_log' => $this->sys_log ?: literal(),
            'user_id' => $this->whenNotNull($this->role_user),
        ];
    }
}
