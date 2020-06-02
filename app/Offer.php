<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'price', 'tax'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'offer_dishes')->orderBy(DB::raw('number + 0'));
    }
}
