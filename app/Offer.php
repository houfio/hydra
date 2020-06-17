<?php

namespace App;

use App\Scopes\IsValidScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new IsValidScope());
        parent::booted();
    }

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

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_offers');
    }
}
