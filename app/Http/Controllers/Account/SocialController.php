<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Users\Entities\Customer;
use Validator, Redirect, Response, File;
use Socialite;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo,$provider);
        Auth::guard('customers')->login($user);
        return redirect()->to('/home');
    }

    function createUser($getInfo,$provider)
    {
        // check if they're an existing user
        $user = Customer::where('email', $getInfo->email)->first();
        //$user = Customer::where('provider_id', $getInfo->id)->first();

        if (!$user) {
            $user = Customer::create([
                'name'       => $getInfo->name,
                'email'      => $getInfo->email,
                'provider'   => $provider,
                'provider_id' => $getInfo->id
            ]);
        }

        return $user;
    }
}
