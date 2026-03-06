<?php

namespace App\Http\Resources\ward;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class WardRoleDataResource extends BaseResource
{
    public function toArray(Request $request): array {
        return array_merge($this->feedbackResource->toArray($request), [
            'content' => WardRoleResource::make($this->resource),
        ]);
    }
}
