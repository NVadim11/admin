<?php

namespace Modules\Core\Tests\Feature;

use Modules\Core\Entities\Modules;
use Modules\Core\Entities\User;
use Tests\TestCase;

class AccessToModuleTest extends TestCase
{
    /**
     * @test
     */
    public function none_auth_user_cant_access_to_admin_panel()
    {
        $response = $this->get(route('admin.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function auth_user_can_access_to_admin_panel()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('admin.index'));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function not_allowed_user_cant_access_to_module()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_access_any_module()
    {
        $user = factory(User::class)->states('manager')->create();
        $this->be($user);

        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function user_can_access_allowed_modules()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $module = Modules::where('name', 'users')->first();
        $module->users()->attach($user);

        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

}
