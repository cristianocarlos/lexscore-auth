<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuSaveResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource('save')->toArray($request), ...[
            'content' => MenuResource::make($this->resource),
        ]];
    }
}
