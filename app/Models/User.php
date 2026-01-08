<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // type -> (superadmin,admin,user)
    // gender -> (1)->female,(2)->male
    // status -> (1)->active,(2)->blocked
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'image',
        'gender',
        'mobile_number',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
}
