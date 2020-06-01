<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferDish extends Pivot
{
    protected $table = 'offer_dishes';

    protected $fillable = [
        'price', 'tax'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function dish()
    {
        return $this->belongsTo(Offer::class);
    }
}
