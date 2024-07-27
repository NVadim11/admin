<?php

namespace App\Services;

use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Subscribers\Entities\Subscriber;

class AccessTokenService
{
	public function makeToken(array $data) : array
	{
		$response['result'] = false;

        $callback = new Subscriber($data);

		try{
            if(!Hash::check(app('settings')->get('api_secret').date("d/m/Y, H:i"), $request->post('token'))) {
                return response()->json(['message' => 'token invalid'], 404);
            }
			$callback->save();
			$response['result'] = true;

		}catch (\Exception $e){
			$this->logger->error($e->getMessage(), $data);
			$response['msg'] = __('app.errors.insert');
		}

		return $response;
	}
}