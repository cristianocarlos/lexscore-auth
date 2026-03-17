<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Models\ward\User as WardUser;
use App\Models\ward\UserToken;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPasswordResetController extends Controller
{
    public function ask(EmailService $emailService): JsonResponse {
        request()->validate([
            'email' => 'required|email',
            'host' => 'required|string',
        ]);
        /** @var WardUser $userModel */
        $userModel = WardUser::where('user_mail', request('email'))->first();
        if (!empty($userModel)) {
            $model = UserToken::tokenSave(userId: $userModel->user_code, email: request('email'));
            $emailService->userPasswordResetSend($model->ustk_toke, $userModel->user_mail, request('host'));
        }
        return response()->json(new JsonFeedbackResource);
    }

    public function confirm(string $token): JsonResponse {
        request()->validate([
            'password' => 'required|confirmed',
        ]);
        /** @var UserToken $model */
        $model = UserToken::notExpiredBuilder()->where('ustk_toke', $token)->first();
        if (!$model) return response()->json(new JsonFeedbackResource('Token expirado', false));
        DB::transaction(function () use ($model) {
            $model->delete();
            WardUser::where('user_mail', $model->ustk_mail)->update([
                'user_pass' => Hash::make(request('password')), // esse tipo de update não usa o cast do model, precisa aplicar o hash manualmente
            ]);
        });
        return response()->json(new JsonFeedbackResource());
    }
}
