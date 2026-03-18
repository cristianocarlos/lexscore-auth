<?php

namespace App\Scopes\ward;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CrudUserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void {}
}
