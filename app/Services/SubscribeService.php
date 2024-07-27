<?php

namespace App\Services;

use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Subscribers\Entities\Subscriber;

class SubscribeService
{
	private $logger;
	private $notify;

	public function __construct(Log $logger, AdminNotify $notify)
	{
		$this->logger = $logger;
		$this->notify = $notify;
	}

	public function addSubscribe(array $data) : array
	{
		$response['result'] = false;

        $callback = new Subscriber($data);

		try{
			$callback->save();
			$response['result'] = true;

		}catch (\Exception $e){
			$this->logger->error($e->getMessage(), $data);
			$response['msg'] = __('app.errors.insert');
		}

//        $view = view('telegram.partner', compact('data'))->render();
//        notifyTelegram($view);

//		Mail::send('emails.partner', array('data' => $data), function ($message) {
//			$message->from(config('mail.from.address'), config('mail.from.name'));
//			$message->to(app('settings')->get('partners_requests_email'), '')->subject('Заявка на партнерство');
//		});


		return $response;
	}
}