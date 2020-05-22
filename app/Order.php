<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function collector()
    {
        return $this->belongsTo(User::class,'collector_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
