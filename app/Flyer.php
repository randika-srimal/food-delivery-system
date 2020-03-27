<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'flyer_area');
    }
}
