<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardRoleRequest;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\WardRoleResource;
use App\Models\WardRole;
use Illuminate\Http\JsonResponse;

class WardRoleController extends Controller
{
    public function create(WardRoleRequest $request): JsonResponse {
        $request->validated();
        $model = new WardRole;
        $model->role_name = request()->post('name');
        $model->role_desc = request()->post('description');
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'create'));
    }

    public function delete(WardRole $model): JsonResponse {
        $model->delete();
        return response()->json(new JsonResponseResource(null, message: 'delete'));
    }

    public function groupIndex(): JsonResponse {
        $query = WardRole::query()->whereNull('role_user');
        return response()->json(new JsonResponseResource(WardRoleResource::collection($query->get())));
    }

    public function userIndex(): JsonResponse {
        $query = WardRole::query()->whereNotNull('role_user');
        return response()->json(new JsonResponseResource(WardRoleResource::collection($query->get())));
    }

    public function update(WardRoleRequest $request, WardRole $model): JsonResponse {
        $request->validated();
        $model->role_name = request()->post('name');
        $model->role_desc = request()->post('description');
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'update'));
    }

    public function view(WardRole $model): JsonResponse {
        return response()->json(new JsonResponseResource(WardRoleResource::make($model)));
    }
}
