<?php

namespace Modules\Core\Tests\Users;

use Modules\Core\Entities\Modules;
use Modules\Core\Entities\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testUserCreateByRequest()
    {
        $request = [
            'name' => 'Test2',
            'login' => 'login',
            'avatar' => 'img/simple.img',
            'email' => 'Test@test.ru',
            'full_access' => 1,
            'password' => md5('test'),
        ];

        $user = User::create($request);

        $this->assertNotEmpty($user->id);
    }

    /**
     * @test
     */
    public function root_is_allowed_in_all_modules()
    {
        $root = User::find(1);

        $this->assertTrue($root->has_access_to('random_module_to_test'));
    }

    /**
     * @test
     */
    public function admin_is_allowed_in_all_modules()
    {
        $user = factory(User::class)->states('manager')->create();

        $this->assertTrue($user->has_access_to('random_module_to_test'));
    }

    /**
     * @test
     */
    public function user_cant_access_module_if_not_allowed()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->has_access_to('random_module_to_test'));
    }

    /**
     * @test
     */
    public function user_has_access_to_module_if_allowed()
    {

        $user = factory(User::class)->create();

        $module = Modules::where('name', 'users')->first();

        $module->users()->attach($user);

        $this->assertTrue($user->has_access_to('users'));
    }

}
