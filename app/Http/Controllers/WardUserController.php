<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\UserResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardUserController extends Controller
{
    public function create(UserCreateRequest $request): JsonResponse {
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
        return response()->json(new JsonResponseResource(UserResource::collection(WardUser::all())));
    }

    public function update(WardUser $model): JsonResponse {
        $model->resolveAttributes(request());
        $model->save();
        return response()->json(new JsonResponseResource($model, message: 'update'));
    }

    public function view(WardUser $model): JsonResponse {
        return response()->json(new JsonResponseResource(UserResource::make($model)));
    }
}
