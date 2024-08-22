<?php

namespace Modules\Notifications\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

	protected $table = "notifications";
	protected $fillable = ['name', 'message', 'image', 'type', 'vis'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){});
    }
}

