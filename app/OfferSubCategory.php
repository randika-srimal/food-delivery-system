<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferSubCategory extends Model
{
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_city');
    }
}
