<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DealDish extends Pivot
{
    protected $table = 'deal_dishes';

    protected $fillable = [
        'price', 'tax'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
