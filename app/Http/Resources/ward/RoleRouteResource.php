<?php

namespace App\Http\Resources\ward;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleRouteResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'label' => $this->path,
            'path' => $this->path,
            'name' => $this->name,
            'controller_path' => $this->controller_path,
            'controller_name' => $this->controller_name,
            'is_checked' => $this->is_checked,
        ];
    }
}
