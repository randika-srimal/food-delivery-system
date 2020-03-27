<?php

namespace App\Http\Controllers;

use App\City;
use App\Flyer;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class FlyersController extends Controller
{
    public function addFlyer(Request $request)
    {
        try {
            $flyer = new Flyer();

            $flyer->file_name = $request->flyer_file_name;
            $flyer->details = $request->details;
            $flyer->save();

            $areasArray = explode(',', $request->areas);

            foreach ($areasArray as $areaName) {
                $capitalizedAreaName = ucwords($areaName);

                $area = City::where('name_en', $capitalizedAreaName)->first();

                if ($area) {
                    $flyer->cities()->save($area);
                }
            }

            return redirect()->back()->with(['status' => 'success', 'message' => 'Pack saved Successfully']);
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
        $flyers=[];

        if ($request->area == "All"){
            $flyers = Flyer::orderBy('id', 'desc')->take(15)->get()->toArray();
        }else{
            $area = City::where('name_en', $request->area)->first();
            $flyers = $area->flyers->toArray();
        }


        return response()->json($flyers);
    }
}
