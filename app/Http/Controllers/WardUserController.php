<?php

namespace App\Http\Controllers;

use App\Http\Requests\WardUserRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\ward\WardUserCollection;
use App\Http\Resources\ward\WardUserDataResource;
use App\Models\WardUser;
use Illuminate\Http\JsonResponse;

class WardUserController extends Controller
{
    public function create(WardUserRequest $request): JsonResponse {
        $request->validated();
        $model = new WardUser;
        $model->resolveAttributes(request());
        $model->save();
        return response()->json(new WardUserDataResource($model, new FeedbackResource(message: 'create')));
    }

    public function delete(WardUser $model): JsonResponse {
        $model->delete();
        return response()->json(new DeleteResource(null));
    }

    public function index(): JsonResponse {
        return response()->json(new WardUserCollection(WardUser::all()));
    }

    public function update(WardUserRequest $request, WardUser $model): JsonResponse {
        $request->validated();
        $model->resolveAttributes(request());
        $model->save();
        return response()->json(new WardUserDataResource($model, new FeedbackResource(message: 'update')));
    }

    public function view(WardUser $model): JsonResponse {
        return response()->json(new WardUserDataResource($model));
    }
}
