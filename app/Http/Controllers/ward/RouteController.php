<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\ward\RoleRouteRowsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function roleRows(int $userId): JsonResponse {
        $sql = <<<SQL
            SELECT rout_code AS id
                 , rout_name AS name
                 , rout_path AS path
                 , rout_ctrl_path AS controller_path
                 , rout_ctrl_name AS controller_name
                 , roro_rout IS NOT NULL AS is_checked
              FROM admin.rbac_route
              LEFT OUTER JOIN admin.rbac_role_route
                ON roro_rout = rout_code
               AND roro_role = :usro_role
             ORDER BY rout_path
        SQL;
        $rows = DB::select($sql, ['usro_role' => $userId]);
        return response()->json(new RoleRouteRowsResource($rows));
    }
}
