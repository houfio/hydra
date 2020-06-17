<?php

namespace App\Scopes;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsValidScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereDate('valid_until', '>', new DateTime())->orWhereNull('valid_until');
    }
}
