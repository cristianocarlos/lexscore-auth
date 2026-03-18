<?php

namespace App\Observers\ward;

use App\Models\ward\CrudUser as ClinicCrudUser;

class CrudUserObserver
{
    public function creating(ClinicCrudUser $model): void {}
}
