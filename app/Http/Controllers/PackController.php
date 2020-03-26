<?php

namespace App\Http\Controllers;

use App\Area;
use App\Order;
use App\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addPack(Request $request)
    {
        try {
            $pack = new Pack();

            $pack->title = $request->title;
            $pack->price = $request->price;
            $pack->items = $request->items;
            $pack->agent_id = Auth::user()->id;

            $pack->save();

            return redirect()->back()->with(['status' => 'success', 'message' => 'Pack saved Successfully']);
        } catch (\Throwable $e) {

            throw $e;
        }
    }

    public function deletePack(Request $request, $id)
    {
        try {
            $pack = Pack::findOrFail($id);
            $pack->is_active = false;
            $pack->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Pack deleted successfully']);
        } catch (\Throwable $e) {

            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function getPacksInArea(Request $request)
    {
        $area = Area::where('name', $request->area)->first();
        $packs = [];

        foreach ($area->users as $user) {
            foreach ($user->packs as $pack) {
                if ($pack->is_active) {
                    $pack['user'] = [
                        'name' => $user->name,
                        'contact_details' => $user->agent_contact_details,
                    ];
                    array_push($packs, $pack);
                }
            }
        }

        return response()->json($packs);
    }
}
