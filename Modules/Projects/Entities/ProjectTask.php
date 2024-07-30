<?php

namespace Modules\Projects\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

	protected $table = "projects_tasks";
    protected $fillable = ['name', 'link', 'reward', 'vis'];
	protected $guarded = ['id'];
    public $timestamps = true;

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){});
    }
}
