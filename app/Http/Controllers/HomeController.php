<?php

namespace App\Http\Controllers;

use App\City;
use App\OfferSubCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller
{
    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['search']);
    }

    public function search(Request $request)
    {
        $deliveryAreaNames = City::pluck('name_en')->toArray();
        $subCategories = OfferSubCategory::all();

        if ($request->input('city')) {
            $city = City::where('name_en', $request->input('city'))->first();
        } else {
            $city = null;
        }

        if ($city) {
            $city->generateShareImage();
        }

        return view('search', [
            'subCategories' => $subCategories,
            'areas' => json_encode($deliveryAreaNames),
            'city' => $city
        ]);
    }

    public function makeCityShareimage($city)
    {
        if (!file_exists(public_path() . 'images/city-shares/city-share-' . $city->id . '.png')) {
            $img = Image::make(public_path('images/city-share-template.png'));
            $img->text($city->name_en, 600, 180, function ($font) {
                $font->file(public_path('fonts/OpenSans-Bold.ttf'));
                $font->size(110);
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
            });
            $img->save(public_path('images/city-shares/city-share-' . $city->id . '.png'));
        }
    }
}
