<?php

namespace App\Observers\ward;

use App\Models\ward\RbacRole;

class RbacRoleObserver
{
    public function creating(RbacRole $model): void {}
}
