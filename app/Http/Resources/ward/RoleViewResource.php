<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\FeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleViewResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new FeedbackResource()->toArray($request), ...[
            'content' => RoleResource::make($this->resource),
        ]];
    }
}
