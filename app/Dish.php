<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $table = 'dishes';

    protected $fillable = [
        'number', 'addition', 'name', 'price', 'description'
    ];

    public function type()
    {
        return $this->belongsTo(DishType::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_dishes')->withPivot('price', 'quantity', 'tax');
    }
}
