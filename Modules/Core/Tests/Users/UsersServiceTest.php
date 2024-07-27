<?php
namespace Modules\Core\Tests\Users;


use Modules\Core\Entities\Modules;
use Modules\Core\Entities\User;
use Modules\Core\Exceptions\ActionNotAllowedException;
use Modules\Core\Services\UserService;
use Tests\TestCase;

/**
 * Class UsersServiceTest
 * @package Modules\Core\Tests\Users
 * @property  UserService $service
 */
class UsersServiceTest extends TestCase
{
    public $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = app()->make(UserService::class);
    }

    /**
     * @test
     */
    public function it_cant_delete_root_user()
    {
        $user = User::find(1);

        $this->expectException(ActionNotAllowedException::class);
        $this->service->deleteUser($user);
    }

    /**
     * @test
     */
    public function admin_can_delete_user()
    {
        $manager = factory(User::class)->states('manager')->create();
        $this->be($manager);

        $user = factory(User::class)->create();

        $this->assertTrue($this->service->deleteUser($user));
    }

    /**
     * @test
     */
    public function not_allowed_user_cant_delete_user()
    {
        $manager = factory(User::class)->create();
        $this->be($manager);

        $user = factory(User::class)->create();

        $this->expectException(ActionNotAllowedException::class);
        $this->service->deleteUser($user);
    }

    /**
     * @test
     */
    public function allowed_user_can_delete_user()
    {
        $manager = factory(User::class)->create();
        $this->be($manager);

        $user = factory(User::class)->create();

        $module = Modules::where('name', 'users')->first();

        $module->users()->attach($manager);

        $this->assertTrue($this->service->deleteUser($user));
    }
}