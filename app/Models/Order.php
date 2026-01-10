<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'payment_mehod',
        'total',
        'city_id',
        'state_id',
        'country_id',
    ];

            /**
     * Get the country that the user belongs to.
     */
    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

    /**
     * Get the state that the user belongs to.
     */
    public function state()
    {
        return $this->hasOne(State::class,'id','state_id');
    }

    /**
     * Get the city that the user belongs to.
     */
    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }


    public function items()
    {
        return $this->hasMany(Order_item::class);
    }

}
