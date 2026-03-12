<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\UserToken;
use Cloudinary\Api\HttpStatusCode;
use Illuminate\Http\JsonResponse;

class UserTokenController extends Controller
{
    public function emailChangeResend(): JsonResponse { // TODO: rate limit
        request()->validate([
                'email' => 'required|email',
            ]);
        $authUser = JwtHelper::getAuthUser();
        UserToken::tokenSave(userId: $authUser->id, email: request()->input('email')); // TODO: funciona input? se funcionar fritar todos posts
        return response()->json(new JsonFeedbackResource);
    }

    public function emailChangeConfirm(string $token): JsonResponse {
        $authUser = JwtHelper::getAuthUser();
        $model = UserToken::notExpiredModel($authUser->id)
            ->whereNotNull('ustk_mail')
            ->where('ustk_toke', $token)
            ->first();
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado'), HttpStatusCode::NOT_FOUND);
        $model->delete();
        return response()->json(new JsonFeedbackResource('E-mail confirmado!'));
    }

    public function passwordResetAsk(string $token): JsonResponse {
        return response()->json(new JsonFeedbackResource);
    }

    public function passwordResetConfirm(string $token): JsonResponse {
        $model = $this->getPasswordResetTokenModel($token);
        return $model
            ? response()->json(new JsonFeedbackResource)
            : response()->json(new JsonFeedbackResource('Token expirado'), HttpStatusCode::NOT_FOUND);
    }

    public function passwordResetSend(string $token): JsonResponse {
        $model = $this->getPasswordResetTokenModel($token);
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado'), HttpStatusCode::NOT_FOUND);
        $model->delete();
        return response()->json(new JsonFeedbackResource('Senha alterada!'));
    }

     private function getPasswordResetTokenModel(string $token): ?UserToken {
        $authUser = JwtHelper::getAuthUser();
        /** @var UserToken $model */
        $model = UserToken::notExpiredModel($authUser->id)
            ->whereNull('ustk_mail')
            ->where('ustk_toke', $token)
            ->first();
        return $model;
    }
}
