<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    // status => (0)->inactive,(1)->active
    protected $fillable = [
        "name",
        "slug",
        "image",
        "status",
        "description"
    ];

    public function products_count()
    {
        return $this->hasMany(Product::class);
    }
}
