<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\User as WardUser;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserPasswordResetController extends Controller
{
    public function ask(EmailService $emailService): JsonResponse {
        request()->validate([
            'email' => 'required|email',
        ]);
        /** @var WardUser $userModel */
        $userModel = WardUser::where('user_mail', request()->input('email'))->first();
        if (!empty($userModel)) {
            $model = UserToken::tokenSave(userId: $userModel->user_code);
            $emailService->userPasswordResetSend($model->ustk_toke, $userModel->user_mail);
        }
        return response()->json(new JsonFeedbackResource);
    }

    public function confirm(string $token): JsonResponse {
        request()->validate([
            'password' => 'required|confirmed',
        ]);
        /** @var UserToken $model */
        $model = UserToken::notExpiredBuilder()->where('ustk_toke', $token)->whereNull('ustk_mail')->first();
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        DB::transaction(function () use ($model) {
            $model->delete();
            $userModel = WardUser::find($model->ustk_user);
            $userModel->user_pass = request()->input('password');
            $userModel->save();
        });
        return response()->json(new JsonFeedbackResource('Senha alterada!'));
    }
}
