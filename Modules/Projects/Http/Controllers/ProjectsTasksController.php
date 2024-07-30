<?php

namespace Modules\Projects\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Projects\Entities\ProjectTask;
use Yajra\DataTables\DataTables;

class ProjectsTasksController extends ProjectsCrudController
{
	protected $isSortable = true;
    protected $outlist = 'datatables';
	protected $templateIndex = 'projects::projects_tasks.index';
	protected $templateAdd = 'projects::projects_tasks.create';
	protected $templateEdit = 'projects::projects_tasks.edit';

	protected $titles = ['Tasks', 'Task'];

	protected function listFields()
	{
		return [
            'name' => [
                'name' => 'Name',
                'type' => 'text'
            ],
            'link' => [
                'name' => 'Link',
                'type' => 'text'
            ],
            'reward' => [
                'name' => 'Reward',
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

	public function getIdUrlParameterName()
	{
		return 'projects_task';
	}

	public function getModel()
	{
		return $this->project->tasks();
	}

    public function index(Request $request)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $route = action($this->getActionRoute('store'), $this->action_url_params);
        $this->titles = [$this->project->name . ': ' . $this->titles[0], $this->titles[1]];
        $size = $request->get('size');
        $this->page_size = isset($size) ? $size : 25;
        $items = $this->crudService->getItems($this->page_size);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $form = $this->crudService->createForm($route);

        $images_table = app(ProjectTask::class)->getTable();
        $table_link = "project_id";
        $item_id = $this->project->id;

        return view($this->templateIndex, [
            'form' => $form,
            'items' => $items,
            'title' => $this->getTitle(),
            'controller' => $this->getController(),
            'add_new_title' => $this->getTitle('create'),
            'fields' => $this->listFields(),
            'sortable' => $this->isSortable,
            'project' => $this->project,
            'outlist' => $this->outlist,
            'page' => $page,
            'images_table' => $images_table,
            'table_link' => $table_link,
            'item_id' => $item_id,
        ]);
    }

    public function create()
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $this->titles = [$this->project->name . ': ' . $this->titles[0], $this->titles[1]];
        $route = action($this->getActionRoute('store'), $this->action_url_params);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $form = $this->crudService->createForm($route, ['id_item' => $this->project->id]);

        return view($this->templateAdd, [
            'form' => $form,
            'title' => $this->getTitle('create'),
            'controller' => $this->getController(),
            'module_title' => $this->getTitle('index'),
            'project' => $this->project,
            'page' => $page
        ]);
    }

	public function edit($id)
	{
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $this->titles = [$this->project->name . ': ' . $this->titles[0], $this->titles[1]];
		$id = \Route::current()->parameter($this->getIdUrlParameterName());
        $route = action($this->getActionRoute('update'), array_merge(['projects_task' => $id], $this->action_url_params));

		$item = $this->crudService->getItemById($id);
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
        $id = \Route::current()->parameter($this->getIdUrlParameterName());
        $item = $this->crudService->update($id);

        return parent::update($id, $request);
    }

	public function ajaxUpdate(Request $request, $id)
	{
		$model = ProjectTask::findOrFail($request->get('pk'));
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;

		$model->save();
	}

	public function actionWithGroup(Request $request){
		switch ($request->post('action')){
			case 'delete':
				foreach ($request->post('items') as $item){
					ProjectTask::find($item)->delete();
				}
				break;
		}
	}

    public function dataTable(Request $request){
        $fields = $this->listFields();

        $model = ProjectTask::query()->where('project_id', $this->project->id)->get();

        $datatable = Datatables::of($model);

        if($this->isSortable) {
            $datatable->addColumn('pos', function ($model) {
                $name = 'pos';
                $value = $model->pos;
                $table = $model->getTable();
                $controller = $this->getController();

                return view('core::list_fields.pos', compact('model', 'value', 'table', 'name', 'controller'));
            });
        }

        foreach($fields as $name => $field){
            $datatable->addColumn($name, function($model) use ($name, $field) {
                $controller = $this->getController();
                $table = $model->getTable();
                $value = $model->$name;
                if(isset($field['type'])) {
                    return view('core::list_fields.' . $field['type'], compact('model', 'value', 'field', 'table', 'name', 'controller'));
                }else{
                    return $model->$name;
                }
            });
        }

        $datatable->addColumn('group', function($model){
            return view('core::list_fields.group', compact('model'));
        });

        $datatable->addColumn('action', function($model){
            $controller = $this->getController();
            return view('core::list_fields.actions', compact('model', 'controller'));
        });

        array_push($fields, 'id');
        array_push($fields, 'group');
        array_push($fields, 'actions');

        $datatable->rawColumns(collect($fields)->keys()->toArray());

        //			->toJson();
        return $datatable->make(true);
    }
}
