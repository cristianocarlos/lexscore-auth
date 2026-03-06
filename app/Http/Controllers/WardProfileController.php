<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedbackResource;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\ward\WardUserDataResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardProfileController extends Controller
{
    public function update(): JsonResponse {
        /** @var WardUser $model */
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->resolveProfileAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, new FeedbackResource(message: 'update')));
    }

    public function view(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        return response()->json(new JsonResponseResource(WardUserDataResource::make($model)));
    }
}
