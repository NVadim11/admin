<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['title', 'text'];

    public $timestamps = false;

    public function modules()
    {
        return $this->belongsToMany(Modules::class, 'group_module', 'group_id', 'module_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
