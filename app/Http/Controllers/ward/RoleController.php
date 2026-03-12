<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\RoleRequest;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\ward\role\RoleRowsResource;
use App\Http\Resources\ward\role\RoleSaveResource;
use App\Http\Resources\ward\role\RoleViewResource;
use App\Http\Resources\ward\userRole\UserRoleRowsResource;
use App\Models\ward\RbacRole;
use App\Queries\ward\RbacRoleQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function create(RoleRequest $request): JsonResponse {
        $request->validated();
        $model = DB::transaction(function () use ($request) {
            $model = new RbacRole;
            $model->resolveAttributes($request);
            $model->save();
            $model->routeAssignmentSave(request()->input('route_assignment'));
            RbacRole::roleAssignmentSave(request()->input('role_assignment'), $model->role_code);
            return $model;
        });
        return response()->json(new RoleSaveResource($model));
    }

    public function delete(RbacRole $model): JsonResponse {
        $model->delete();
        return response()->json(new JsonFeedbackResource('delete'));
    }

    public function groupIndex(): JsonResponse {
        $query = RbacRole::query()->whereNull('role_user');
        return response()->json(new RoleRowsResource($query->get()));
    }

    public function groupRoleRows(int $roleId): JsonResponse {
        return response()->json(new UserRoleRowsResource(RbacRoleQuery::getGroupRoleRows($roleId)));
    }

    public function userIndex(): JsonResponse {
        $query = RbacRole::query()->whereNotNull('role_user');
        return response()->json(new RoleRowsResource($query->get()));
    }

    public function update(RoleRequest $request, RbacRole $model): JsonResponse {
        $request->validated();
        $model = DB::transaction(function () use ($request, $model) {
            $model->resolveAttributes($request);
            $model->save();
            $model->routeAssignmentSave(request()->input('route_assignment'));
            RbacRole::roleAssignmentSave(request()->input('role_assignment'), $model->role_code);
            return $model;
        });
        return response()->json(new RoleSaveResource($model));
    }

    public function view(RbacRole $model): JsonResponse {
        return response()->json(new RoleViewResource($model));
    }
}
