<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function flyers()
    {
        return $this->belongsToMany(Flyer::class, 'flyer_city');
    }
}
