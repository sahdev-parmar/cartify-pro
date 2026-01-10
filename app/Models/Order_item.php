<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity'
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
