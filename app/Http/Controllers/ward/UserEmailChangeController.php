<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\User as WardUser;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class UserEmailChangeController extends Controller
{
    public function ask(EmailService $emailService): JsonResponse {
        request()->validate([
            'email' => 'required|email',
            'host' => 'required|string',
        ]);
        $authUser = JwtHelper::getAuthUser();
        $model = UserToken::tokenSave(userId: $authUser->id, email: request('email'));
        $emailService->userEmailChangeSend($model->ustk_toke, $model->ustk_mail, request('host'));
        return response()->json(new JsonFeedbackResource);
    }

    public function confirm(string $token): JsonResponse {
        /** @var UserToken $model */
        $model = UserToken::notExpiredBuilder()->where('ustk_toke', $token)->first();
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        $userModel = WardUser::find($model->ustk_user);
        $userModel->user_mail = $model->ustk_mail;
        $userModel->save();
        // Exclui todas as solicitações deste usuário, caso isso não aconteça pode ficar uma solicitação dupla pendurada eternamente
        UserToken::where('ustk_user', $model->ustk_user)->delete();
        return response()->json(new JsonFeedbackResource);
    }
}
