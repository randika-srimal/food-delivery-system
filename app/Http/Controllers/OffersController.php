<?php

namespace App\Http\Controllers;

use App\City;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class OffersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getOffersInCity']);
    }

    public function saveOffer(Request $request)
    {
        try {
            $offer = new Offer();

            $offer->file_name = $request->flyer_file_name;
            $offer->details = $request->details;
            $offer->user_id = Auth::user()->id;
            $offer->sub_category_id = $request->sub_category_id;
            $offer->save();

            $areasArray = explode(',', $request->areas);

            foreach ($areasArray as $areaName) {
                $capitalizedAreaName = ucwords($areaName);

                $city = City::where('name_en', $capitalizedAreaName)->first();

                if ($city) {
                    $offer->cities()->save($city);
                }
            }

            return redirect()->route('search')->with(['status' => 'success', 'message' => 'Offer saved Successfully']);
        } catch (\Throwable $e) {

            throw $e;
        }
    }

    public function saveOfferImage(Request $request)
    {
        try {
            $hashName = hash_file('md5', $request->file_data->path());
            $fileName = $hashName . time() . '.' . $request->file_data->extension();

            $thumbPath = public_path('images/offers/thumb-' . $fileName);
            $path = public_path('images/offers/' . $fileName);

            Image::make($request->file_data->getRealPath())->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath);

            Image::make($request->file_data->getRealPath())->save($path);

            return response()->json([
                'uploadedFileName' => $fileName
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ])->setStatusCode(400);
        }
    }

    public function getOffersInCity(Request $request)
    {
        $offers = [];

        if ($request->city == "") {
            $offers = Offer::orderBy('id', 'desc')->with('user')->take(15)->get()->toArray();
        } else {
            $city = City::where('name_en', $request->city)->first();
            $offers = $city->offers->sortByDesc('id')->load('user')->values();
        }


        return response()->json($offers);
    }

    public function deleteOffer(Request $request,$id)
    {
        $offer = Offer::find($id);
        $offer->delete();
        return response()->json($offer->id);
    }
}
