<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperType
 */
class File extends Model
{
    protected $table = 'misc.file';
    protected $primaryKey = 'file_code';

    public function profilePhotoSave(?string $value): void {
    }
}
