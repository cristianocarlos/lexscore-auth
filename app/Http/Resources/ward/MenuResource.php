<?php

namespace App\Http\Resources\ward;

use App\Models\ward\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Menu
 */
class MenuResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'id' => $this->menu_code,
            'name' => $this->menu_name,
            'parent_id' => $this->menu_menu,
            'parent_id_desc' => $this->menu_menu_desc,
            'route_id' => $this->menu_rout,
            'route_id_desc' => $this->menu_rout_desc,
            'shortcut_data' => $this->menu_shcu_data,
        ];
    }
}
