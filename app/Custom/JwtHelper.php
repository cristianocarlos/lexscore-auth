<?php

namespace App\Custom;

use App\Http\Resources\JsonResponseResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtHelper
{
    const string REFRESH_TOKEN_NAME = 'refresh-token';
    private const string REFRESH_TOKEN_COOKIE_PATH = '/';
    private const int REFRESH_TOKEN_COOKIE_DURATION_IN_DAYS = 14;

    private static function setRefreshTokenCookie(?string $value, string $cookieName): SymfonyCookie {
        return cookie(
            name: $cookieName,
            value: $value,
            minutes: $value ? 60 * 24 * static::REFRESH_TOKEN_COOKIE_DURATION_IN_DAYS : -1,
            path: static::REFRESH_TOKEN_COOKIE_PATH,
            domain: config('session.refresh_token_domain'), // para poder acessar o tokem em outro subdomínio
            secure: config('session.secure', false),
            httpOnly: true,
            raw: false,
            sameSite: config('session.same_site', 'lax'),
        );
    }

    public static function refreshTokenGenerate(int $userId, string $cookieName): string {
        return JWTAuth::getJWTProvider()->encode([
            'iss' => config('app.url'),
            'iat' => now()->timestamp,
            'exp' => now()->addDays(static::REFRESH_TOKEN_COOKIE_DURATION_IN_DAYS)->timestamp,
            'sub' => $userId,
            'type' => $cookieName,
            'jti' => bin2hex(random_bytes(16)),
            'rot' => now()->timestamp,
        ]);
    }

    public static function refreshTokenValidate(string $refreshToken, string $cookieName): array {
        try {
            // Tabela id, user_id, created_at, expired_at
            // $payload = RefreshToken::where('id', $refreshToken)->first();
            // if (($payload->exp ?? 0) < now()->timestamp) return [];
            $payload = JWTAuth::getJWTProvider()->decode($refreshToken);
            if (($payload['exp'] ?? 0) < now()->timestamp) return [];
            if (($payload['type'] ?? '') !== $cookieName) return [];
            if (array_any(['iss', 'sub', 'jti', 'rot'], fn ($claim) => !isset($payload[$claim]))) {
                return [];
            }
            return $payload;
        } catch (JWTException $e) {
            return [];
        }
    }

    public static function responseJsonWithExpiredCookie(string $message, string $cookieName, int $httpStatusCode = JsonResponse::HTTP_UNAUTHORIZED): JsonResponse {
        return response()->json(new JsonResponseResource(
            null,
            message: $message,
            success: false,
        ), $httpStatusCode)
            ->withCookie(static::setRefreshTokenCookie(null, $cookieName));
    }

    public static function responseJsonLogout(string $message, string $cookieName): JsonResponse {
        // JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(new JsonResponseResource(
            null,
            message: $message,
            success: true,
        ))
            ->withCookie(static::setRefreshTokenCookie(null, $cookieName));
    }

    public static function responseJsonWithAccessTokenAndCookie(
        string $accessToken,
        Model $userModel,
        string $refreshToken,
        string $cookieName,
        string $guard,
    ): JsonResponse {
        $content = [
            'access_token' => $accessToken,
            'token_type' => 'bearer',
            'expires_in' => auth($guard)->factory()->getTTL() * 60,
            'user_data' => $userModel,
        ];
        if (!app()->isProduction()) {
            $content = array_merge($content, [
                '__debug__new_refresh-token' => substr($refreshToken, -8),
                '__debug__old_refresh-token' => substr(request()->cookie($cookieName), -8),
            ]);
        }

        return response()->json(new JsonResponseResource($content))
            ->withCookie(static::setRefreshTokenCookie($refreshToken, $cookieName));
    }
}
