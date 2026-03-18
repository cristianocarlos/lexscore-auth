<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\UserRequest;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\ward\user\UserRowsResource;
use App\Http\Resources\ward\user\UserSaveResource;
use App\Http\Resources\ward\user\UserViewResource;
use App\Models\ward\CrudUser as WardCrudUser;
use App\Models\ward\RbacRole;
use Illuminate\Http\JsonResponse;

class CrudUserController extends Controller
{
    public function create(UserRequest $request): JsonResponse {
        $request->validated();
        $model = new WardCrudUser;
        $model->resolveAttributes(request());
        $model->save();
        RbacRole::roleAssignmentSave(request('role_assignment'), $model->user_code);
        return response()->json(new UserSaveResource($model));
    }

    public function delete(WardCrudUser $model): JsonResponse {
        $model->delete();
        return response()->json(new JsonFeedbackResource('delete'));
    }

    public function index(): JsonResponse {
        return response()->json(new UserRowsResource(WardCrudUser::limit(10)->get()));
    }

    public function update(UserRequest $request, WardCrudUser $model): JsonResponse {
        $request->validated();
        $model->resolveAttributes(request());
        $model->save();
        RbacRole::roleAssignmentSave(request('role_assignment'), $model->user_code);
        return response()->json(new UserSaveResource($model));
    }

    public function view(WardCrudUser $model): JsonResponse {
        return response()->json(new UserViewResource($model));
    }
}
