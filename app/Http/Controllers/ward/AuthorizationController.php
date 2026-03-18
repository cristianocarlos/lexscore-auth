<?php

namespace App\Http\Controllers\ward;

use App\Custom\JwtHelper;
use App\Custom\Rbac;
use App\Custom\RbacMenu;
use App\Http\Controllers\Controller;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\JsonResponseResource;
use Illuminate\Http\JsonResponse;

class AuthorizationController extends Controller
{
    public function rbac(): JsonResponse {
        request()->validate([
            'routePath' => 'required|string',
        ]);
        try {
            $data = Rbac::authorization(routePath: request('routePath'));
            return response()->json(new JsonResponseResource($data));
        } catch (\Exception $e) {
            return response()->json(new JsonResponseResource([
                'authorize' => false,
                'message' => $e->getMessage(),
            ]));
        }
    }

    public function menu(): JsonResponse {
        try {
            $menuTree = new RbacMenu(JwtHelper::getAuthUser()?->id)->recursiveMenuGenerate(null);
            return response()->json(new JsonResponseResource($menuTree));
        } catch (\Exception $e) {
            return response()->json(new JsonFeedbackResource(message: $e->getMessage(), success: false));
        }
    }
}
