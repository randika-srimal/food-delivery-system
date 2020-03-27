<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
    public function cities()
    {
        return $this->belongsToMany(City::class, 'flyer_city');
    }
}
