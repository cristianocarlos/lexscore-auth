<?php

namespace App\Http\Controllers;

use App\Custom\JwtHelper;
use App\Models\WardUser;
use App\Rules\CloudflareTurnstileWardValidate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class WardAuthController extends Controller
{
    const string REFRESH_TOKEN_NAME = JwtHelper::REFRESH_TOKEN_NAME;
    const string GUARD = 'intranet';

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'LoginForm.cf_turnstile_response' => ['required', new CloudflareTurnstileWardValidate],
            'LoginForm.username' => 'required',
            'LoginForm.password' => 'required',
        ], [
            'LoginForm.cf_turnstile_response.required' => 'Captcha verification empty. Please try again',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userModel = WardUser::findByUsername($request->input('LoginForm.username'));
        if (!$userModel or !$userModel->validatePassword($request->input('LoginForm.password'))) {
            return response()->json([
                'success' => false,
                'errors' => ['LoginForm.password' => ['Credenciais de acesso incorretas']],
            ], JsonResponse::HTTP_UNAUTHORIZED);
        } else {
            $userModel->sys_log = array_merge((array) $userModel->sys_log, [
                'last_login_date_hour' => now()->format('Y-m-d H:i:sT'),
                'login_count' => ($userModel->sys_log['login_count'] ?? 0) + 1,
            ]);
            $userModel->save();
        }
        $accessToken = JWTAuth::fromUser($userModel);

        $refreshToken = JwtHelper::refreshTokenGenerate($userModel->user_code, static::REFRESH_TOKEN_NAME);

        return JwtHelper::respondJsonWithAccessTokenAndCookie(
            $accessToken,
            $userModel,
            $refreshToken,
            static::REFRESH_TOKEN_NAME,
            static::GUARD,
        );
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->cookie(static::REFRESH_TOKEN_NAME);
            if (!$refreshToken) {
                return response()->json(['success' => false, 'message' => 'Refresh token not found'], JsonResponse::HTTP_UNAUTHORIZED);
            }

            $refreshPayload = JwtHelper::refreshTokenValidate($refreshToken, static::REFRESH_TOKEN_NAME);
            if (empty($refreshPayload)) return JwtHelper::respondJsonWithExpiredCookie('Invalid refresh token', static::REFRESH_TOKEN_NAME);

            $userModel = WardUser::find($refreshPayload['sub']);
            if (!$userModel) return JwtHelper::respondJsonWithExpiredCookie('User not found', static::REFRESH_TOKEN_NAME, JsonResponse::HTTP_NOT_FOUND);
            $newAccessToken = auth(static::GUARD)->login($userModel);
            $newRefreshToken = JwtHelper::refreshTokenGenerate($userModel->user_code, static::REFRESH_TOKEN_NAME);

            return JwtHelper::respondJsonWithAccessTokenAndCookie(
                $newAccessToken,
                $userModel,
                $newRefreshToken,
                static::REFRESH_TOKEN_NAME,
                static::GUARD,
            );

        } catch (\Exception $e) {
            return JwtHelper::respondJsonWithExpiredCookie('Token refresh failed: ' . $e->getMessage(), static::REFRESH_TOKEN_NAME);
        }
    }

    public function reactivate(Request $request): JsonResponse
    {
        $userModel = WardUser::find($request->input('LoginForm.username'));
        if (!$userModel or !$userModel->validatePassword($request->input('LoginForm.password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $accessToken = JWTAuth::fromUser($userModel);
        $refreshToken = JwtHelper::refreshTokenGenerate($userModel->user_code, static::REFRESH_TOKEN_NAME);

        return JwtHelper::respondJsonWithAccessTokenAndCookie(
            $accessToken,
            $userModel,
            $refreshToken,
            static::REFRESH_TOKEN_NAME,
            static::GUARD,
        );
    }

    public function logout(): JsonResponse
    {
        auth(static::GUARD)->logout();

        return JwtHelper::respondJsonLogout('Successfully logged out', static::REFRESH_TOKEN_NAME);
    }

    public function deactivate(): JsonResponse
    {
        return JwtHelper::respondJsonLogout('Successfully deactivated', static::REFRESH_TOKEN_NAME);
    }
}
