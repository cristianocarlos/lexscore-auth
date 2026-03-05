<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardUserRequest;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\WardUserResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardUserController extends Controller
{
    public function create(WardUserRequest $request): JsonResponse {
        $request->validated();
        $model = new WardUser;
        $model->resolveAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'create'));
    }

    public function delete(WardUser $model): JsonResponse {
        $model->delete();
        return response()->json(new JsonResponseResource(null, message: 'delete'));
    }

    public function index(): JsonResponse {
        return response()->json(new JsonResponseResource(WardUserResource::collection(WardUser::all())));
    }

    public function update(WardUser $model): JsonResponse {
        $model->resolveAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'update'));
    }

    public function view(WardUser $model): JsonResponse {
        return response()->json(new JsonResponseResource(WardUserResource::make($model)));
    }
}
