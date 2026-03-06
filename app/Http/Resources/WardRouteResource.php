<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WardRoute
 */
class WardRouteResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->rout_code,
            'name' => $this->rout_name,
            'path' => $this->rout_path,
        ];
    }
}
