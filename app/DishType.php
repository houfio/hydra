<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DishType extends Model
{
    protected $table = 'dish_types';

    protected $fillable = [
        'name'
    ];

    public function dishes()
    {
        return $this->hasMany(Dish::class, 'type_id')->orderBy(DB::raw('number + 0'));
    }
}
