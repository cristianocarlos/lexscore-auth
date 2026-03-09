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
        ];
    }
}
