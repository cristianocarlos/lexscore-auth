<?php

namespace App\Http\Resources\ward\menu;

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
            'parent_id' => $this->whenNotNull($this->menu_menu),
            'parent_id_desc' => $this->whenNotNull($this->menu_menu_desc),
            'route_id' => $this->whenNotNull($this->menu_acti),
            'route_id_desc' => $this->whenNotNull($this->menu_acti_desc),
            'shortcut_data' => $this->whenNotNull($this->menu_shcu_data),
        ];
    }
}
