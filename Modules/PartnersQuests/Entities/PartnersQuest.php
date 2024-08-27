<?php

namespace Modules\PartnersQuests\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersQuest extends Model
{
    use HasFactory;

	protected $table = "partners_quests";
	protected $fillable = ['name', 'name_ru', 'link', 'reward', 'type', 'vis'];
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

