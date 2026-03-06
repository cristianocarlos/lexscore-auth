<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\ward\UserSaveResource;
use App\Http\Resources\ward\UserViewResource;
use App\Models\ward\User as WardUser;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function update(): JsonResponse {
        /** @var WardUser $model */
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->resolveProfileAttributes(request());
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function view(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        return response()->json(new UserViewResource($model));
    }
}
