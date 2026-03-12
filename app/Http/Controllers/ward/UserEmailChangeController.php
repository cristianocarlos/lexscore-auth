<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\User;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class UserEmailChangeController extends Controller
{
    public function ask(EmailService $emailService): JsonResponse {
        request()->validate([
            'email' => 'required|email',
        ]);
        $authUser = JwtHelper::getAuthUser();
        $model = UserToken::tokenSave(userId: $authUser->id, email: request()->input('email'));
        $emailService->userEmailChangeSend($model->ustk_toke, $model->ustk_mail);
        return response()->json(new JsonFeedbackResource);
    }

    public function confirm(string $token): JsonResponse {
        /** @var UserToken $model */
        $model = UserToken::notExpiredBuilder()->where('ustk_toke', $token)->whereNotNull('ustk_mail')->first();
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        $userModel = User::find($model->ustk_user);
        $userModel->user_mail = $model->ustk_mail;
        $userModel->save();
        $model->delete();
        return response()->json(new JsonFeedbackResource('E-mail confirmado!'));
    }
}
