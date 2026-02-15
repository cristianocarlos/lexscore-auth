<?php

namespace App\Http\Resources;

use App\Models\misc\Type;
use App\Models\WardUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WardUser
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->user_code ?: $this->getNextSequence(),
            'email' => $this->whenNotNull($this->user_mail),
            'has_password' => (bool) $this->user_pass,
            'preferences' => $this->whenNotNull($this->user_pref_data),
            'status_id' => $this->user_stat,
            'status_name' => Type::getName($this->user_stat),
        ];
    }
}
