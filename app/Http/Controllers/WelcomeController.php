<?php

namespace App\Http\Controllers;

use App\City;

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
        $deliveryAreaNames = City::pluck('name_en')->toArray();

        return view('search', ['areas' => json_encode($deliveryAreaNames)]);
    }
}
