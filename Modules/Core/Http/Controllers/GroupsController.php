<?php

namespace Modules\Core\Http\Controllers;


use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Modules\Core\Entities\Group;

class GroupsController extends CrudController
{
    protected $titles = ['Groups', 'group'];
    public $isSortable = false;

	protected function listFields()
	{
		return [
			'title' => [
				'name' => 'Name',
				'type' => 'text'
			]
		];
	}

    public function store(Request $request)
    {
        $item = $this->crudService->store();

        $item->modules()->attach($request['modules']);
        $item->users()->attach($request['users']);

        return $this->redirectToAction('index', $this->action_url_params);
    }

//	public function index(Request $request)
//	{
//		$users = Group::where('id', '<>', '1')->get();
//
//		return view('core::groups.index', compact('users'));
//	}

    public function edit($id)
    {
        $item = $this->crudService->getItemById($id)->load(['modules', 'users']);
        $route = action($this->getActionRoute('update'), array_merge(['group' => $id], $this->action_url_params));
        $form = $this->crudService->getEditForm($item, $route);

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'item' => $item,
        ]);
    }

    public function update($id, Request $request)
    {
        $item = $this->crudService->update($id);

        $item->modules()->sync($request['modules']);
        $item->users()->sync($request['users']);

        return $this->redirectToAction('index', $this->action_url_params);
    }

	public function ajaxUpdate(Request $request, $id)
	{
		$model = Service::findOrFail($id);
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;

		$model->save();
	}
}
