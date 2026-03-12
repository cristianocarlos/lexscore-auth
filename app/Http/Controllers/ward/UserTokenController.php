<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\User;
use App\Models\ward\UserToken;
use Illuminate\Http\JsonResponse;

class UserTokenController extends Controller
{
    public function emailChangeResend(): JsonResponse {
        request()->validate([
            'email' => 'required|email',
        ]);
        $authUser = JwtHelper::getAuthUser();
        try {
            UserToken::tokenSaveAndMail(userId: $authUser->id, email: request()->input('email'));
            return response()->json(new JsonFeedbackResource);
        } catch (\Exception $e) {
            return response()->json(new JsonFeedbackResource($e->getMessage(), false), JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function emailChangeConfirm(string $token): JsonResponse {
        $model = $this->getTokenModel($token, 'email');
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        $userModel = User::find($model->ustk_user);
        $userModel->user_mail = $model->ustk_mail;
        $userModel->save();
        $model->delete();
        return response()->json(new JsonFeedbackResource('E-mail confirmado!'));
    }

    public function passwordResetAsk(string $token): JsonResponse {
        return response()->json(new JsonFeedbackResource);
    }

    public function passwordResetConfirm(string $token): JsonResponse {
        $model = $this->getTokenModel($token, 'password');
        return $model
            ? response()->json(new JsonFeedbackResource)
            : response()->json(new JsonFeedbackResource('Token expirado', false));
    }

    public function passwordResetSend(string $token): JsonResponse {
        $model = $this->getTokenModel($token, 'password');
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        $model->delete();
        return response()->json(new JsonFeedbackResource('Senha alterada!'));
    }

    private function getTokenModel(string $token, string $type): ?UserToken {
        $builder = UserToken::notExpiredBuilder()->where('ustk_toke', $token);
        $type === 'email' ? $builder->whereNotNull('ustk_mail') : $builder->whereNull('ustk_mail');
        return $builder->first();
    }
}
