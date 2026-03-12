<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\ward\roleRoute\RoleRouteRowsResource;
use App\Queries\ward\RbacRouteQuery;
use Illuminate\Http\JsonResponse;

class RouteController extends Controller
{
    public function roleRows(int $roleId): JsonResponse {
        return response()->json(new RoleRouteRowsResource(RbacRouteQuery::getRoleRows($roleId)));
    }

    public function suggest(): JsonResponse {
        request()->validate([
            'term' => 'sometimes|string',
            'limit' => 'integer',
            'offset' => 'integer',
            'roleId' => 'integer',
        ]);
        return response()->json(new JsonResponseResource(RbacRouteQuery::getSuggestOptions(
            term: request()->query('term'),
            limit: request()->query('limit'),
            offset: request()->query('offset'),
            roleId: request()->query('roleId'),
        )));
    }
}
