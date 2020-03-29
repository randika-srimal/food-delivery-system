<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function cities()
    {
        return $this->belongsToMany(City::class, 'offer_city');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offerSubCategory()
    {
        return $this->belongsTo(OfferSubCategory::class);
    }

    public static function boot()
    {
        parent::boot();

        Offer::deleted(function ($offer) {
            $file_path = public_path() . '/images/offers/' . $offer->file_name;
            unlink($file_path);
            $thumb_file_path = public_path() . '/images/offers/thumb-' . $offer->file_name;
            unlink($thumb_file_path);
        });
    }
}
