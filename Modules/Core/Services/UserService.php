<?php
namespace Modules\Core\Services;


use Modules\Core\Entities\User;
use Modules\Core\Exceptions\ActionNotAllowedException;

class UserService
{
    public function deleteUser(User $user)
    {
        if($user->id === 1 || !\Auth::user()->has_access_to('users')){
            throw new ActionNotAllowedException();
        }

        $user->delete();

        return true;
    }
}