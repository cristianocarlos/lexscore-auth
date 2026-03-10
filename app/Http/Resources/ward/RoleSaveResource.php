<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleSaveResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource(message: 'save')->toArray($request), ...[
            'content' => RoleResource::make($this->resource),
        ]];
    }
}
