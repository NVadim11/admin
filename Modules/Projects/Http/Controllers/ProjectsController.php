<?php

namespace Modules\Projects\Http\Controllers;

use App\Services\RedisService;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CrudController;
use Modules\Projects\Entities\Project;

class ProjectsController extends CrudController
{
    protected $isSortable = true;
    protected $outlist = 'datatables';
//    protected $templateIndex = 'projects::projects.index';
    protected $templateEdit = 'projects::projects.edit';
    protected $titles = ['Projects', 'Project'];
    protected $sortOrder = 'ASC';
    protected $sortValue = 2;

    protected function listFields()
    {
        return [
            'image' => [
                'name' => 'Image',
                'type' => 'image'
            ],
            'name' => [
                'name' => 'Name',
                'type' => 'text'
            ],
            'vote_total' => [
                'name' => 'Votes Total',
                'type' => 'text'
            ],
            'vote_24' => [
                'name' => 'Votes 24',
                'type' => 'text'
            ],
            'vis' => [
                'name' => 'Display',
                'type' => 'option',
                'choises' => [
                    1 => 'Yes',
                    0 => 'No'
                ]
            ]
        ];
    }

	public function store(Request $request)
    {
        $item = $this->crudService->store();
        return $this->redirectToAction('index');
    }

    public function index(Request $request)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $route = action($this->getActionRoute('store'), $this->action_url_params);
        $this->page_size = isset($_GET['size']) ? $_GET['size'] : 10;
        $items = $this->crudService->getItems($this->page_size);

        $form = $this->crudService->createForm($route);

        return view($this->templateIndex, [
            'form' => $form,
            'items' => $items,
            'title' => $this->getTitle(),
            'add_new_title' => $this->getTitle('create'),
            'controller' => $this->getController(),
            'fields' => $this->listFields(),
            'sortable' => $this->isSortable,
            'sortOrder' => $this->sortOrder,
            'sortValue' => $this->sortValue,
            'outlist' => $this->outlist,
        ]);
    }
    
    public function edit($id)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), ['project' => $id]);
        $form = $this->crudService->getEditForm($item, $route);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'item' => $item,
			'page' => $page
        ]);
    }

    public function update($id, Request $request)
    {
		$page = $request->post('page') ? $request->post('page') : 1;
        $this->crudService->update($id);
        $redis = new RedisService();
        $redis->deleteIfExists('projects_list');

        return $this->redirectToAction('index', 'page=' . $page);
    }

    public function destroy($id)
    {
        $this->crudService->getItemById($id);
        $this->crudService->destroy($id);
        $redis = new RedisService();
        $redis->deleteIfExists('projects_list');

        return $this->redirectToAction('index', $this->action_url_params);
    }

    public function ajaxUpdate(Request $request, $id)
	{
		$model = Project::findOrFail($id);
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;
		$model->save();
        $redis = new RedisService();
        $redis->deleteIfExists('projects_list');
	}
}
