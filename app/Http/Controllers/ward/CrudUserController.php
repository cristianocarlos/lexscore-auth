<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\UserRequest;
use App\Http\Resources\JsonFeedbackResource;
use App\Http\Resources\JsonResponseResource;
use App\Http\Resources\ward\user\CrudUserRowsResource;
use App\Http\Resources\ward\user\CrudUserSaveResource;
use App\Http\Resources\ward\user\CrudUserViewResource;
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
        return response()->json(new CrudUserSaveResource($model));
    }

    public function delete(WardCrudUser $model): JsonResponse {
        $model->delete();
        return response()->json(new JsonFeedbackResource('delete'));
    }

    public function index(): JsonResponse {
        return response()->json(new CrudUserRowsResource(WardCrudUser::limit(10)->get()));
    }

    function photoLoad(WardCrudUser $model) {
        return response()->json(new JsonResponseResource($model->user_phot));
    }

    public function update(UserRequest $request, WardCrudUser $model): JsonResponse {
        $request->validated();
        $model->resolveAttributes(request());
        $model->save();
        RbacRole::roleAssignmentSave(request('role_assignment'), $model->user_code);
        return response()->json(new CrudUserSaveResource($model));
    }

    public function view(WardCrudUser $model): JsonResponse {
        return response()->json(new CrudUserViewResource($model));
    }
}
