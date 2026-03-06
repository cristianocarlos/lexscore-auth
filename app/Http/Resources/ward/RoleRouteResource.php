<?php

namespace App\Http\Resources\ward;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleRouteResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'is_checked' => $this->is_checked,
        ];
    }
}
