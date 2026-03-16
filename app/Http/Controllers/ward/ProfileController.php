<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ward\UserRequest;
use App\Http\Resources\ward\user\UserSaveResource;
use App\Http\Resources\ward\user\UserViewResource;
use App\Models\ward\User as WardUser;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function personalInfoUpdate(UserRequest $request): JsonResponse {
        $request->validated();
        $authUser = JwtHelper::getAuthUser();
        $model = WardUser::find($authUser->id);
        $model->user_cpf = request('cpf');
        $model->user_mail = request('email');
        $model->user_name = request('name');
        $model->user_pers_data = request('personal_data');
        $model->user_phot = request('photo');
        $model->save();
        return response()->json(new UserSaveResource($model));
    }

    public function preferencesUpdate(EmailService $emailService): JsonResponse {
        $authUser = JwtHelper::getAuthUser();
        $model = WardUser::find($authUser->id);
        $oldEmail = $model->user_mail;
        if ($oldEmail !== request('email')) {
            try {
                $model = UserToken::tokenSave(userId: $authUser->id, email: request('email'));
                $emailService->userEmailChangeSend($model->ustk_toke, $model->ustk_mail);
            } catch (\Exception $e) {
                // Se der ruim aqui tanto faz, o usuário pode clicar no resend
            }
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
