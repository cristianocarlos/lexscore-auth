<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\WardRouteResource;
use App\Models\WardRoute;
use Illuminate\Http\JsonResponse;

class WardRouteController extends Controller
{
    public function index(): JsonResponse {
        return response()->json(new JsonResponseResource(WardRouteResource::collection(WardRoute::all())));
    }
}
