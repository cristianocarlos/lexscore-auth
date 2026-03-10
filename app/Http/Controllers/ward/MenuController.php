<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\MenuRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\ward\MenuTreeResource;
use App\Http\Resources\ward\MenuSaveResource;
use App\Http\Resources\ward\MenuViewResource;
use App\Models\ward\Menu;
use App\Queries\ward\MenuQuery;
use Dedoc\Scramble\Attributes\Response;
use Dedoc\Scramble\Support\Type\ObjectType;
use Dedoc\Scramble\Support\Type\Type;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function create(MenuRequest $request): JsonResponse {
        $request->validated();
        $model = new Menu;
        $model->resolveAttributes($request);
        $model->save();
        return response()->json(new MenuSaveResource($model));
    }

    public function delete(Menu $model): JsonResponse {
        $model->delete();
        return response()->json(new DeleteResource(null));
    }

    public function index(): JsonResponse {
        return response()->json(new MenuTreeResource(MenuQuery::getTree()));
    }

    public function update(MenuRequest $request, Menu $model): JsonResponse {
        $request->validated();
        $model->resolveAttributes($request);
        $model->save();
        return response()->json(new MenuSaveResource($model));
    }

    public function view(Menu $model): JsonResponse {
        return response()->json(new MenuViewResource($model));
    }
}
