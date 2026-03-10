<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\RoleRequest;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\ward\RoleRowsResource;
use App\Http\Resources\ward\RoleSaveResource;
use App\Http\Resources\ward\RoleViewResource;
use App\Http\Resources\ward\UserRoleRowsResource;
use App\Models\ward\RbacRole;
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
            $model->routeAssignmentSave(request()->post('route_assignment'));
            $model->roleAssignmentSave(request()->post('role_assignment'));
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

    /**
     * Lista das grupos com as respectivas atribuições a role
     */
    public function groupRoleRows(int $roleId): JsonResponse {
        $sql = <<<SQL
            SELECT role_code AS id
                 , role_name AS name
                 , role_desc AS description
                 , usro_user IS NOT NULL AS is_assigned
              FROM admin.rbac_role
              LEFT OUTER JOIN admin.rbac_user_role
                ON usro_role = role_code
               AND usro_user = :usro_user
             WHERE role_user IS NULL
             ORDER BY F_CI(role_name)
        SQL;
        $rows = DB::select($sql, ['usro_user' => $roleId]);
        return response()->json(new UserRoleRowsResource($rows));
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
            $model->routeAssignmentSave(request()->post('route_assignment'));
            $model->roleAssignmentSave(request()->post('role_assignment'));
            return $model;
        });
        return response()->json(new RoleSaveResource($model));
    }

    public function view(RbacRole $model): JsonResponse {
        return response()->json(new RoleViewResource($model));
    }
}
