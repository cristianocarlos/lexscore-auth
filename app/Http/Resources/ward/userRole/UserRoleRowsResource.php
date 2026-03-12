<?php

namespace App\Http\Resources\ward\userRole;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleRowsResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource()->toArray($request), ...[
            'content' => UserRoleResource::collection($this->resource),
        ]];
    }
}
