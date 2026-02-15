<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardUserController extends Controller
{
    public function create(UserCreateRequest $request): JsonResponse {
        $request->validated();
        $model = new WardUser;
        $model->requestFill();
        $model->save();
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'post' => request()->post(),
            'model' => $model,
        ]);
    }

    public function delete(WardUser $model): JsonResponse {
        $model->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    public function index(): JsonResponse {
        return response()->json(UserResource::collection(WardUser::all()));
    }

    public function update(WardUser $model): JsonResponse {
        $model->requestFill();
        $model->save();
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ]);
    }

    public function view(WardUser $model): JsonResponse {
        return response()->json(UserResource::make($model));
    }
}
