<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\RoleRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\ward\RoleResource;
use App\Http\Resources\ward\RoleRowsResource;
use App\Http\Resources\ward\RoleSaveResource;
use App\Http\Resources\ward\RoleViewResource;
use App\Models\ward\RbacRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function create(RoleRequest $request): JsonResponse {
        $request->validated();
        $model = DB::transaction(function () {
            $model = new RbacRole;
            $model->role_name = request()->post('name');
            $model->role_desc = request()->post('description');
            $model->save();
            $model->permissionsSave(request()->post('permissions'));
            return $model;
        });
        return response()->json(new RoleSaveResource($model));
    }

    public function delete(RbacRole $model): JsonResponse {
        $model->delete();
        return response()->json(new DeleteResource(null));
    }

    public function groupIndex(): JsonResponse {
        $query = RbacRole::query()->whereNull('role_user');
        return response()->json(new RoleRowsResource($query->get()));
    }

    public function userIndex(): JsonResponse {
        $query = RbacRole::query()->whereNotNull('role_user');
        return response()->json(new RoleRowsResource($query->get()));
    }

    public function update(RoleRequest $request, RbacRole $model): JsonResponse {
        $request->validated();
        $model = DB::transaction(function () use ($model) {
            $model->role_name = request()->post('name');
            $model->role_desc = request()->post('description');
            $model->save();
            $model->permissionsSave(request()->post('permissions'));
            return $model;
        });
        return response()->json(new RoleSaveResource($model));
    }

    public function view(RbacRole $model): JsonResponse {
        return response()->json(new RoleViewResource(RoleResource::make($model)));
    }
}
