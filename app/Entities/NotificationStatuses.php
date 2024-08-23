<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationStatuses extends Model
{
    use HasFactory;

	protected $table = "notification_statuses";
	protected $fillable = ['id_telegram', 'notification_type'];
	protected $guarded = ['id'];
	public $timestamps = true;
}

