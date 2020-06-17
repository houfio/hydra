<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderOffer extends Pivot
{
    protected $table = 'order_offers';

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

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
