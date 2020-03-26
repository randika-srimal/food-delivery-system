<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Response, File;
use Socialite;
use App\User;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return FacadesSocialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $getInfo = FacadesSocialite::driver($provider)->user();
            $user = $this->createUser($getInfo, $provider);
            auth()->login($user);
            return redirect()->to('/');   //code...
        } catch (\Throwable $th) {
            return redirect()->to('/login')->with(['status' => 'danger', 'message' => 'Facebook Login Failed']);
        }
    }
    function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->name,
                'username'     => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }
}
