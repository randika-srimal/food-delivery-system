<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function generateShareImage(Request $request)
    {
        echo "omitting closing tag"
        try {
            if ($request->city_name) {
                $city = City::where('name_en', $request->city_name)->first();
                $city->generateShareImage()
                return response()->json($city->id)
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
