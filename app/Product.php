<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'product_id', 'id');
    }

}
