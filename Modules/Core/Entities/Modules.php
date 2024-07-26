<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $fillable = ['name', 'section', 'title', 'description', 'hidden'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'module_user', 'module_id', 'user_id');
    }
}
