<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'deal_dishes')->withPivot('price', 'tax');
    }
}
