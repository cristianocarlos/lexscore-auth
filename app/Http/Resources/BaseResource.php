<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public FeedbackResource $feedbackResource;

    public function __construct($resource, ?FeedbackResource $feedbackResource = null) {
        parent::__construct($resource);
        $this->feedbackResource = $feedbackResource ?: new FeedbackResource();
    }
}
