<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'order_dishes')->withPivot('price', 'quantity', 'tax', 'note');
    }
}
