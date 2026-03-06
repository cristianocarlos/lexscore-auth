<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class WardUserCollection extends BaseResource
{
    public function toArray(Request $request): array {
        return array_merge($this->feedbackResource->toArray($request), [
            'content' => WardUserResource::collection($this->resource),
        ]);
    }
}
