<?php
namespace Modules\Core\Services;

use Illuminate\Support\Facades\Hash;

class AccessTokenService
{
    public function checkToken($token) {
        return Hash::check(app('settings')->get('api_secret').date("d/m/Y, H:i"), $token);
    }
}