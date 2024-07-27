<?php

namespace Modules\Core\Tests;


use App\Http\Middleware\VerifyCsrfToken;
use Modules\Core\Entities\User;
use Modules\Sanatoriums\Entities\Sanatorium;
use Tests\TestCase;

abstract class CrudModule extends TestCase
{
    abstract function module_url_name();
    abstract function factory_class();
    abstract function request_array();

    public function getEntry()
    {
        return factory($this->factory_class())->create();
    }

    /**
     * @test
     */
    public function it_can_be_viewed()
    {
        $this->acting_as_admin();

        $request = $this->get('/admin/'.$this->module_url_name());

        $request->assertStatus(200);
    }


    /**
     * @test
     */
    public function add_page_available()
    {
        $this->withoutExceptionHandling();
        $this->acting_as_admin();

        $request = $this->get('/admin/'.$this->module_url_name().'/create');

        $request->assertStatus(200);
    }

    /**
     * @test
     */
    public function edit_page_is_available()
    {
        $this->acting_as_admin();

        $entry = $this->getEntry();

        $request = $this->get('/admin/'.$this->module_url_name().'/'.$entry->id.'/edit');

        $request->assertStatus(200);
    }

    /**
     * @test
     */
    public function delete_one_entry_is_available()
    {
        $this->acting_as_admin();
        $entry = $this->getEntry();

        $this->delete('/admin/'.$this->module_url_name().'/'.$entry->id);

        $request = $this->get('/admin/'.$this->module_url_name().'/'.$entry->id.'/edit');

        $request->assertStatus(404);
    }

    /**
     * @test
     */
    public function user_can_add_new_entry()
    {
        $this->acting_as_admin();

        $request = $this->post('/admin/'.$this->module_url_name(), $this->request_array());
        $request->assertRedirect('/admin/'.$this->module_url_name());

        $entry = $this->factory_class()::orderBy('id', 'DESC')->first();
        $this->assertNotNull($entry);

        $request = $this->get('/admin/'.$this->module_url_name().'/'.$entry->id.'/edit');
        $request->assertStatus(200);

    }


    protected function acting_as_admin()
    {
        $user = factory(User::class)->states('manager')->make();
        $this->be($user);
    }
}