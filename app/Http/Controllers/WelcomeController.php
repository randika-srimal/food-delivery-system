<?php

namespace App\Http\Controllers;

use App\Area;
use App\Help;
use App\Order;
use App\Pack;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
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

    public function search()
    {
        $deliveryAreaNames = Area::pluck('name')->toArray();

        return view('search', ['areas' => json_encode($deliveryAreaNames)]);
    }

    public function dashboard()
    {
        if (Auth::user()->id == 1) {
            return view('systemAdminDashboard');;
        }

        if (!Auth::user()->is_agent) {
            $deliveryAreaNames = Area::pluck('name')->toArray();

            $orders = Auth::user()->orders->sortByDesc('created_at');

            return view('userDashboard', ['orders' => $orders, 'areas' => json_encode($deliveryAreaNames)]);
        } else {
            try {
                $packs = Pack::where('agent_id', Auth::user()->id)
                    ->get();

                $packIdsArray = $packs->pluck('id')->toArray();

                $placedOrders = Order::whereIn('pack_id', $packIdsArray)->whereIn('status', ['Placed', 'Accepted'])->paginate(10);
                $otherOrders = Order::whereIn('pack_id', $packIdsArray)->whereNotIn('status', ['Placed', 'Accepted'])->paginate(10);

                return view('agentDashboard', ['placedOrders' => $placedOrders, 'otherOrders' => $otherOrders, 'packs' => $packs]);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['status' => 'danger', 'message' => $th->getMessage()]);
            }
        }
    }
}
