<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperWardRoute
 */
class WardRoute extends Model
{
    protected $table = 'admin.rbac_route';
    protected $primaryKey = 'rout_code';
    public $timestamps = false;
    protected $casts = [];

    // Custom column names
    protected $fillable = [];
}
