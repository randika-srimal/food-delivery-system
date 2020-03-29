<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class City extends Model
{
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_city');
    }

    public function generateShareimage()
    {
        if (!file_exists(public_path() . 'images/city-shares/city-share-' . $this->id . '.png')) {
            $img = Image::make(public_path('images/city-share-template.png'));
            $img->text($this->name_en, 600, 180, function ($font) {
                $font->file(public_path('fonts/OpenSans-Bold.ttf'));
                $font->size(110);
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
            });
            $img->save(public_path('images/city-shares/city-share-' . $this->id . '.png'));
        }
    }
}
