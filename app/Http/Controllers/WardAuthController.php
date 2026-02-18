<?php

namespace App\Http\Controllers;

use App\Custom\JwtHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\JsonResponseResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WardAuthController extends Controller
{
    const string REFRESH_TOKEN_NAME = JwtHelper::REFRESH_TOKEN_NAME;

    public function login(LoginRequest $request): JsonResponse {
        $request->validated(); // nem precisaria, o LoginRequest já resolve
        $userModel = WardUser::findByUsername($request->input('LoginForm.username'));
        if (!$userModel or !$userModel->validatePassword($request->input('LoginForm.password'))) {
            return response()->json(new JsonResponseResource(
                null,
                errors: ['LoginForm.password' => ['Credenciais de acesso incorretas']],
            ), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $userModel->resolveSysLog([
                'login_count' => ($userModel->sys_log['login_count'] ?? 0) + 1,
                'login_last_date_hour' => now()->format('Y-m-d H:i:sT'),
            ]);
            $userModel->save();
        }
        $accessToken = JWTAuth::fromUser($userModel);

        $refreshToken = JwtHelper::refreshTokenGenerate($userModel->user_code, static::REFRESH_TOKEN_NAME);

        return JwtHelper::responseJsonWithAccessTokenAndCookie(
            $accessToken,
            $userModel,
            $refreshToken,
            static::REFRESH_TOKEN_NAME,
            WardUser::AUTH_GUARD,
        );
    }

    public function refresh(Request $request): JsonResponse {
        try {
            $errorStatusCode = JsonResponse::HTTP_UNAUTHORIZED;
            $refreshToken = $request->cookie(static::REFRESH_TOKEN_NAME);
            if (!$refreshToken) {
                return response()->json(new JsonResponseResource(null, message: 'Refresh token not found', success: false), $errorStatusCode);
            }

            $refreshPayload = JwtHelper::refreshTokenValidate($refreshToken, static::REFRESH_TOKEN_NAME);
            if (empty($refreshPayload)) {
                return JwtHelper::responseJsonWithExpiredCookie(
                    'Invalid refresh token',
                    static::REFRESH_TOKEN_NAME,
                    $errorStatusCode,
                );
            }

            $userModel = WardUser::find($refreshPayload['sub']);
            if (!$userModel) {
                return JwtHelper::responseJsonWithExpiredCookie(
                    'User not found',
                    static::REFRESH_TOKEN_NAME, $errorStatusCode,
                );
            }

            $newAccessToken = auth(WardUser::AUTH_GUARD)->login($userModel);
            $newRefreshToken = JwtHelper::refreshTokenGenerate($userModel->user_code, static::REFRESH_TOKEN_NAME);

            return JwtHelper::responseJsonWithAccessTokenAndCookie(
                $newAccessToken,
                $userModel,
                $newRefreshToken,
                static::REFRESH_TOKEN_NAME,
                WardUser::AUTH_GUARD,
            );

        } catch (\Exception $e) {
            return JwtHelper::responseJsonWithExpiredCookie(
                'Token refresh failed: ' . $e->getMessage(),
                static::REFRESH_TOKEN_NAME,
            );
        }
    }

    public function logout(): JsonResponse {
        auth(WardUser::AUTH_GUARD)->logout();
        return JwtHelper::responseJsonLogout(
            'Successfully logged out',
            static::REFRESH_TOKEN_NAME,
        );
    }
}
