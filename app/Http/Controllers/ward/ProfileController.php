<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ward\UserRequest;
use App\Http\Resources\ward\user\UserSaveResource;
use App\Http\Resources\ward\user\UserViewResource;
use App\Models\ward\User as WardUser;
use App\Models\ward\UserToken;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function personalInfoUpdate(UserRequest $request): JsonResponse {
        $request->validated();
        $authUser = JwtHelper::getAuthUser();
        $model = WardUser::find($authUser->id);
        $model->user_cpf = request()->input('cpf');
        $model->user_mail = request()->input('email');
        $model->user_name = request()->input('name');
        $model->user_pers_data = request()->input('personal_data');
        $model->user_phot = request()->input('photo');
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function preferencesUpdate(): JsonResponse {
        $authUser = JwtHelper::getAuthUser();
        $model = WardUser::find($authUser->id);
        $oldEmail = $model->user_mail;
        if ($oldEmail !== request()->input('email')) {
            // Não salva o novo email enquanto
            UserToken::tokenSave(userId: $authUser->id, email: request()->input('email'));
        }
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function view(): JsonResponse {
        $authUser = JwtHelper::getAuthUser();
        $model = WardUser::find($authUser->id);
        return response()->json(new UserViewResource($model));
    }
}
