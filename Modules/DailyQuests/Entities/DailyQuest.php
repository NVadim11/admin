<?php

namespace Modules\DailyQuests\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyQuest extends Model
{
    use HasFactory;

	protected $table = "daily_quests";
	protected $fillable = ['name', 'name_ru', 'link', 'reward', 'required_amount', 'required_referrals', 'vis'];
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