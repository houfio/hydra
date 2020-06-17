<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderDish extends Pivot
{
    protected $table = 'order_dishes';

    protected $fillable = [
        'price', 'tax', 'quantity', 'note'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
