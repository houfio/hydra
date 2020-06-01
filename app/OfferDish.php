<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferDish extends Pivot
{
    protected $table = 'offer_dishes';

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function dish()
    {
        return $this->belongsTo(Offer::class);
    }
}
