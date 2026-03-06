<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardRoleRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\ward\WardRoleCollection;
use App\Http\Resources\ward\WardRoleDataResource;
use App\Http\Resources\ward\WardRoleResource;
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
        return response()->json(new WardRoleDataResource($model, new FeedbackResource(message: 'create')));
    }

    public function delete(WardRole $model): JsonResponse {
        $model->delete();
        return response()->json(new DeleteResource(null));
    }

    public function groupIndex(): JsonResponse {
        $query = WardRole::query()->whereNull('role_user');
        return response()->json(new WardRoleCollection($query->get()));
    }

    public function userIndex(): JsonResponse {
        $query = WardRole::query()->whereNotNull('role_user');
        return response()->json(new WardRoleCollection($query->get()));
    }

    public function update(WardRoleRequest $request, WardRole $model): JsonResponse {
        $request->validated();
        $model->role_name = request()->post('name');
        $model->role_desc = request()->post('description');
        $model->save();
        return response()->json(new WardRoleDataResource($model, new FeedbackResource(message: 'update')));
    }

    public function view(WardRole $model): JsonResponse {
        return response()->json(new WardRoleDataResource(WardRoleResource::make($model)));
    }
}
