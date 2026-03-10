<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSaveResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource('save')->toArray($request), ...[
            'content' => UserResource::make($this->resource),
        ]];
    }
}
