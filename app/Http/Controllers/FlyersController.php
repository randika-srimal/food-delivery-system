<?php

namespace App\Http\Controllers;

use App\Area;
use App\Flyer;
use Illuminate\Http\Request;
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
            $flyer->price = $request->price;
            $flyer->save();

            $areasArray = explode(',', $request->areas);

            foreach ($areasArray as $areaName) {
                $capitalizedAreaName = ucwords($areaName);

                $area = Area::where('name', $capitalizedAreaName)->first();

                if ($area === null) {
                    $area = new Area();
                    $area->name = $capitalizedAreaName;

                    $area->save();
                }

                $flyer->areas()->save($area);
            }

            return redirect()->back()->with(['status' => 'success', 'message' => 'Flyer saved Successfully']);
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
        $area = Area::where('name', $request->area)->first();
        // $packs = [];

        // foreach ( as $flyer) {
        //         $pack['user'] = [
        //             'name' => $user->name,
        //             'contact_details' => $user->agent_contact_details,
        //         ];
        //         array_push($packs, $pack);
        // }

        return response()->json($area->flyers->toArray());
    }
}
