<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Enums\YiiEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ward\UserRequest;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\ward\user\CrudUserSaveResource;
use App\Http\Resources\ward\user\CrudUserViewResource;
use App\Models\ward\AuthUser as WardAuthUser;
use App\Models\ward\CrudUser as WardCrudUser;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function passwordUpdate(): JsonResponse {
        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        $authUser = JwtHelper::getAuthUser();
        $model = WardAuthUser::find($authUser->id);
        if (!$model->validatePassword(request('current_password'))) {
            return response()->json(
                new JsonFeedbackResource(errors: ['current_password' => ['Senha incorreta']]),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
        $model->user_pass = request('new_password');
        $model->save();
        return response()->json(new JsonFeedbackResource('save'));
    }

    public function personalInfoUpdate(UserRequest $request): JsonResponse {
        $request->validated();
        $authUser = JwtHelper::getAuthUser();
        $model = WardCrudUser::find($authUser->id);
        $model->user_cpf = request('cpf');
        $model->user_mail = request('email');
        $model->user_name = request('name');
        $model->user_pers_data = request('personal_data');
        $model->user_phot = request('photo');
        $model->save();
        return response()->json(new CrudUserSaveResource($model));
    }

    function preferencesLoad(WardCrudUser $model) {
        return response()->json(new JsonResponseResource($model->user_pref_data));
    }

    public function preferencesUpdate(EmailService $emailService): JsonResponse {
        request()->validate([
            'email' => 'required|email',
            'host' => 'required|string',
        ]);
        $authUser = JwtHelper::getAuthUser();
        $model = WardCrudUser::find($authUser->id);
        $oldEmail = $model->user_mail;
        if ($oldEmail !== request('email')) {
            try {
                $userTokenModel = UserToken::tokenSave(userId: $authUser->id, email: request('email'), typeId: YiiEnum::USER_TOKEN_EMAIL_CHANGE->value);
                $emailService->userEmailChangeSend($userTokenModel->ustk_toke, $userTokenModel->ustk_mail, request('host'));
            } catch (\Exception $_e) {
                // Se der ruim aqui tanto faz, o usuário pode clicar no resend
            }
        }
        $model->save();
        return response()->json(new CrudUserSaveResource($model));
    }

    public function view(): JsonResponse {
        $authUser = JwtHelper::getAuthUser();
        $model = WardCrudUser::find($authUser->id);
        return response()->json(new CrudUserViewResource($model));
    }
}
