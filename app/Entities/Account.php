<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $rememberTokenName = 'remember_token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'phone', 'first_name', 'last_name', 'birthday', 'notify', 'avatar', 'test_result',
        'provider', 'provider_id', 'gender', 'hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'saved_to_later' => 'array'
    ];


    public function getMenuUserName()
    {
        if($this->first_name) {
            $name = trim($this->first_name . ' ' . $this->last_name);
        } else {
            $name = $this->email;
        }

        return $name;
    }

    public function getQuestionnaireResult()
    {
        return $this->test_result;
    }

    public function setQuestionnaireResult(integer $result)
    {
        // TODO:
    }

    /**
     * Append from session and save
     */
    public function appendSavedToLater()
    {
        $saved_to_later = $this->saved_to_later ?: [];
        $this->saved_to_later = array_unique(
            array_merge($saved_to_later, session('saveToLater'))
        );
        $this->save();

        session(['saveToLater' => $this->saved_to_later]);
    }

    /**
     * Setup from session
     */
    public function updateSavedToLater()
    {
        $this->saved_to_later = session('saveToLater') ?: [];
        $this->save();
    }

    public function redirectOnLogin()
    {
        if(session('redirect_on_login')) {

            $redirect_on_login = session('redirect_on_login');

            session()->forget('redirect_on_login');
            session()->flush();

            return redirect($redirect_on_login);
        } else {
            return redirect()
                ->intended(route('user'))
                ->with('status', 'You are Logged in as Customer!');
        }
    }
}