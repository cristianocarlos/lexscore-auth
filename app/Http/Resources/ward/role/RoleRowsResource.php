<?php

namespace App\Http\Resources\ward\role;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleRowsResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource()->toArray($request), ...[
            'content' => RoleResource::collection($this->resource),
        ]];
    }
}
