<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [

        'name', 'email', 'password', 'provider', 'provider_id'

    ];

    protected $hidden = ['password', 'email'];

    public function flyers()
    {
        // return $this->belongsToMany(Flyer::class, 'flyer_city');
    }
}
