<?php

namespace App\Models\ward;

use App\Models\IdeHelperFile;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    protected $table = 'misc.file';
    protected $primaryKey = 'file_code';

    public function profilePhotoSave(?string $value): void {}
}
