<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResponseResource extends JsonResource
{
    public FeedbackResource $feedbackResource;

    public function __construct($resource, ?FeedbackResource $feedbackResource = null) {
        parent::__construct($resource);
        $this->feedbackResource = $feedbackResource ?: new FeedbackResource;
    }

    public function toArray(Request $request): array {
        return array_merge($this->feedbackResource->toArray($request), [
            'content' => $this->whenNotNull($this->resource),
        ]);
    }
}
