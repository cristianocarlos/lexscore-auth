<?php

namespace App\Http\Resources\ward\user;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrudUserSaveResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource('save')->toArray($request), ...[
            'content' => CrudUserResource::make($this->resource),
        ]];
    }
}
