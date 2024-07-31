<?php

namespace Modules\Projects\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Имя таблицы, можно опустить если имя соответствует конвенциям Laravel
    protected $table = "projects";

    // Поля, которые могут быть заполнены массово
    protected $fillable = [
        'name',
        'image',
        'vote_total',
        'vote_24',
        'vis'
    ];

    protected $guarded = ['id'];

    public $timestamps = true;

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->orderBy('pos', 'ASC');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTasks()
    {
        return $this->hasMany(ProjectTask::class)->where('vis', 1)->orderBy('pos', 'ASC');
    }
}