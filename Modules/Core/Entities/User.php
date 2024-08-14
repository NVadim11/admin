<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $fillable = [
        'name', 'email', 'password', 'login', 'avatar', 'full_access', 'notify', 'notify_review', 'locale', 'auth_verify', 'auth_verify_secret'
    ];

	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function modules()
    {
        return $this->belongsToMany(Modules::class, 'module_user', 'user_id', 'module_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function is_admin()
    {
        return $this->id === 1 || $this->full_access;
    }

    public function scopeNotified($query)
    {
        return $query->where('notify', 1);
    }

    public function scopeReviewNotified($query)
    {
        return $query->where('notify_review', 1);
    }

    //TODO: Refactor this. Move to service
    public function has_access_to($module_name)
    {
        if($this->is_admin()){
            return true;
        }

        $module = Modules::where('name', $module_name)->first();

        if(!$module){
            return true;
        }

        if($module
           && ( $this->modules()->where('name', $module_name)->first()
           || $this->groups()->whereHas('modules', function ($query) use ($module_name) {
                $query->where('name', $module_name);
            })->first() )
        ){
            return true;
        }

        return false;
    }
}
