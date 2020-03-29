<?php

namespace App\Http\Controllers;

use App\City;
use App\Flyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class FlyersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getFlyersInArea']);
    }

    public function addFlyer(Request $request)
    {
        try {
            $flyer = new Flyer();

            $flyer->file_name = $request->flyer_file_name;
            $flyer->details = $request->details;
            $flyer->user_id = Auth::user()->id;
            $flyer->save();

            $areasArray = explode(',', $request->areas);

            foreach ($areasArray as $areaName) {
                $capitalizedAreaName = ucwords($areaName);

                $area = City::where('name_en', $capitalizedAreaName)->first();

                if ($area) {
                    $flyer->cities()->save($area);
                }
            }

            return redirect()->route('search')->with(['status' => 'success', 'message' => 'Pack saved Successfully']);
        } catch (\Throwable $e) {

            throw $e;
        }
    }

    public function tryUpload(Request $request)
    {
        try {
            $hashName = hash_file('md5', $request->file_data->path());
            $fileName = $hashName . time() . '.' . $request->file_data->extension();

            $thumbPath = public_path('images/flyers/thumb-' . $fileName);
            $path = public_path('images/flyers/' . $fileName);

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

    public function getFlyersInArea(Request $request)
    {
        $flyers = [];

        if ($request->area == "") {
            $flyers = Flyer::orderBy('id', 'desc')->with('user')->take(15)->get()->toArray();
        } else {
            $city = City::where('name_en', $request->area)->first();
            $flyers = $city->flyers->sortByDesc('id')->load('user')->values();
        }


        return response()->json($flyers);
    }

    public function deleteFlyer(Request $request,$id)
    {
        $flyer = Flyer::find($id);
        $flyer->delete();
        $file_path = public_path().'/images/flyers/'.$flyer->file_name;
        unlink($file_path);
        $thumb_file_path = public_path().'/images/flyers/thumb-'.$flyer->file_name;
        unlink($thumb_file_path);


        return response()->json($flyer->id);
    }
}
