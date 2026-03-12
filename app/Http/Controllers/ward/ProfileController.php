<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\ward\UserSaveResource;
use App\Http\Resources\ward\UserViewResource;
use App\Models\ward\User as WardUser;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function personalInfoUpdate(): JsonResponse {
        /** @var WardUser $model */
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->user_cpf = request()->input('cpf');
        $model->user_mail = request()->input('email');
        $model->user_name = request()->input('name');
        $model->user_pers_data = request()->input('personal_data');
        $model->user_phot = request()->input('photo');
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function preferencesUpdate(): JsonResponse {
        /** @var WardUser $model */
        $model = auth(WardUser::AUTH_GUARD)->user();
        $model->user_mail = request()->input('email');
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function view(): JsonResponse {
        $model = auth(WardUser::AUTH_GUARD)->user();
        return response()->json(new UserViewResource($model));
    }
}
