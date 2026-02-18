<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\UserResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardProfileController extends Controller
{
    public function update(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->resolveProfileAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'update'));
    }

    public function view(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        return response()->json(new JsonResponseResource(UserResource::make($model)));
    }
}
