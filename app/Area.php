<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_area');
    }

    public function flyers()
    {
        return $this->belongsToMany(Flyer::class, 'flyer_area');
    }
}
