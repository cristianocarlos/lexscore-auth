<?php

namespace App\Models\ward;

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
    protected $casts = [];

    // Custom column names
    protected $fillable = [
        'menu_name',
    ];

    public function resolveAttributes(Request $request): void {
        $this->menu_name = $request->post('name');
    }
}
