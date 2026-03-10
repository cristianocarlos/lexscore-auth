<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\ward\RoleRouteRowsResource;
use App\Queries\ward\RbacRouteQuery;
use Illuminate\Http\JsonResponse;

class RouteController extends Controller
{
    public function roleRows(int $roleId): JsonResponse {
        return response()->json(new RoleRouteRowsResource(RbacRouteQuery::getRoleRows($roleId)));
    }
}
