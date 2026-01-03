<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //(1)->In_stock(2)->out_of_stock

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_status',
        'category_id',
        'sales_count',
        'images'
    ];

    public function category()
    {
       return $this->hasOne(Category::class,'id','category_id');    
    }
}
