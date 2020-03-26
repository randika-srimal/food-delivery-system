<?php

namespace App\Http\Controllers;

use App\Area;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changeStatus(Request $request, $id, $status)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = $status;
            $order->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Order ' + $status + ' successfully']);
        } catch (\Throwable $e) {

            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function addOrder(Request $request)
    {
        try {
            $area  = Area::where('name', $request->area_name)->first();

            $help = new Order();

            $help->address = $request->address;
            $help->phone = $request->phone;
            $help->required_date = $request->required_date ? $request->required_date : Carbon::today()->toDateString();
            $help->area_id = $area->id;
            $help->other = $request->other;
            $help->pack_id = $request->pack_id;
            $help->user_id = Auth::user()->id;

            $help->save();

            return redirect()->back()->with(['status' => 'success', 'message' => 'Order Placed Successfully']);
        } catch (\Throwable $e) {

            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
}
