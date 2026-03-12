<?php

namespace App\Http\Resources\ward\roleRoute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleRouteResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'name' => $this->name,
            'controller_path' => $this->controller_path,
            'controller_name' => $this->whenNotNull($this->controller_name),
            'is_assigned' => $this->is_assigned,
            'assigned_by' => $this->whenNotNull($this->assigned_by),
        ];
    }
}
