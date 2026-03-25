<?php

namespace App\Http\Resources\ward\user;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrudUserRowsResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource()->toArray($request), ...[
            'content' => CrudUserResource::collection($this->resource),
        ]];
    }
}
