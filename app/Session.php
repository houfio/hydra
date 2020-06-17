<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'table'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
