<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeleteResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [...new FeedbackResource(message: 'delete')->toArray($request), ...[
            'content' => $this->whenNotNull($this->resource),
        ]];
    }
}
