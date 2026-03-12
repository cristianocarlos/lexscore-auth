<?php

namespace App\Http\Resources\ward\menu;

use App\Http\Resources\JsonFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuTreeResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new JsonFeedbackResource()->toArray($request), ...[
            'content' => $this->resource, // TODO: não sei como fazer usar o Resource pra items recursivos
        ]];
    }
}
