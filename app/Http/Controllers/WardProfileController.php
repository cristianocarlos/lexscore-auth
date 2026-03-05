<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\WardUserResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardProfileController extends Controller
{
    public function update(): JsonResponse {
        /** @var WardUser $model */
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->resolveProfileAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'update'));
    }

    public function view(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        return response()->json(new JsonResponseResource(WardUserResource::make($model)));
    }
}
