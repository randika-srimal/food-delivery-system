<?php

namespace App\Http\Controllers;

use App\Area;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addUser(Request $request)
    {
        try {
            $user = new User();

            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->agent_contact_details = $request->agent_contact_details;
            $user->is_agent = true;

            $user->save();

            $areasArray = explode(',', $request->areas);

            foreach ($areasArray as $areaName) {
                $capitalizedAreaName = ucwords($areaName);

                $area = Area::where('name', $capitalizedAreaName)->first();

                if ($area === null) {
                    $area = new Area();
                    $area->name = $capitalizedAreaName;

                    $area->save();
                }

                $user->areas()->save($area);
            }

            return redirect()->back()->with(['status' => 'success', 'message' => 'Username - ' . $request->username . ',Password - ' . $request->password]);
        } catch (\Throwable $e) {

            return redirect()->back()->withInput()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
}
