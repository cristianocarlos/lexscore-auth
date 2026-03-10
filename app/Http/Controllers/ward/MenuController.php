<?php

namespace App\Http\Controllers\ward;

use App\Http\Controllers\Controller;
use App\Http\Requests\ward\MenuRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\ward\MenuSaveResource;
use App\Http\Resources\ward\MenuTreeResource;
use App\Http\Resources\ward\MenuViewResource;
use App\Models\ward\Menu;
use App\Queries\Query;
use App\Queries\ward\MenuQuery;
use App\Rules\RecursiveTreeRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function reorder(Request $request): JsonResponse {
        $request->validate([
            'items' => ['required', 'array', new RecursiveTreeRule([
                'id' => 'required|integer',
                'name' => 'required|string',
                'shortcut_icon_name' => 'nullable|string',
                'shortcut_name' => 'nullable|string',
                'sortable_parent_id' => 'nullable|integer',
                'url_path' => 'nullable|string',
                'items' => 'nullable|array',
            ])],
        ]);
        DB::transaction(function () {
            Query::recursiveItemsReorder(request()->post('items'), function ($data, $index) {
                Menu::where('menu_code', $data['id'])->update(['menu_orde' => $index + 1]);
            });
        });
        return response()->json(new FeedbackResource);
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
