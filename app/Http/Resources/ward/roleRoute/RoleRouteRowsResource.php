<?php

namespace App\Http\Resources\ward\roleRoute;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleRouteRowsResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource()->toArray($request), ...[
            'content' => RoleRouteResource::collection($this->resource),
        ]];
    }
}
