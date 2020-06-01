<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'price', 'tax'
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'offer_dishes');
    }
}
