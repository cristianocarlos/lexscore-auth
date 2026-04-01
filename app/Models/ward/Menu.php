<?php

namespace App\Models\ward;

use App\Casts\ward\MenuShcuDataCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @mixin IdeHelperMenu
 */
class Menu extends Model
{
    protected $table = 'admin.menu';
    protected $primaryKey = 'menu_code';
    public $timestamps = false;
    protected $casts = [
        'menu_shcu_data' => MenuShcuDataCast::class,
    ];
    protected $fillable = [
        'menu_name',
        'menu_acti',
        'menu_menu',
        'menu_shcu_data',
    ];

    public function resolveAttributes(Request $request): void {
        $this->menu_name = $request->input('name');
        $this->menu_acti = $request->input('route_id');
        $this->menu_menu = $request->input('parent_id');
        $this->menu_shcu_data = $request->input('shortcut_data');
    }

    protected $appends = ['menu_menu_desc', 'menu_acti_desc'];

    public static function getName(?int $id) {
        if (!$id) return null;
        return static::where('menu_code', $id)->value('menu_name');
    }

    public function getMenuMenuDescAttribute() {
        return static::getName($this->menu_menu);
    }

    public function getMenuActiDescAttribute() {
        return RbacRoute::getName($this->menu_acti);
    }
}
