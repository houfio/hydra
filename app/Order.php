<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'orders';

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'order_dishes')->withPivot('price', 'quantity', 'tax', 'note')->orderBy(DB::raw('number+0'));
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'order_offers')->withPivot('price', 'quantity', 'tax', 'note');
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
