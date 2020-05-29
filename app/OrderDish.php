<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDish extends Model
{
    protected $table = 'order_dishes';

    protected $fillable = [
        'price', 'tax'
    ];
}
