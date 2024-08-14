<?php

namespace App\Notifications;


use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Modules\Core\Entities\User;

class AdminNotify
{
    private $logger;

    public function __construct(Log $logger)
    {
        $this->logger = $logger;
    }

    public function notify(Notification $notification)
    {
        $admins = $this->notifiedUsers($notification);

        try{
            \Illuminate\Support\Facades\Notification::send($admins, $notification);
        }catch (\Exception $e){
            $this->logger->error($e->getMessage(), [$admins, $notification]);
        }
    }

    public function notifiedUsers(Notification $notification)
    {
        if($notification instanceof NewReviewNotify){
            $users = User::reviewNotified()->get();
        }else{
            $users = User::notified()->get();
        }

        return $users;
    }
}