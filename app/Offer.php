<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'offer_dishes')->withPivot('price', 'tax');
    }
}
