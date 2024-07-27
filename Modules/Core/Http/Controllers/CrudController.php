<?php

namespace Modules\Core\Http\Controllers;

use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Core\Exceptions\ClassNotSpecifiedException;
use Modules\Core\Services\CrudService\CrudServiceFactory;
use View;
use Yajra\DataTables\DataTables;

abstract class CrudController extends Controller
{

    protected $crudService;
    protected $sortOrder = 'DESC';
    protected $sortValue = 'id';
    protected $action_url_params = [];
    protected $page_size = 25;
    protected $outlist = 'default';
    /**
     * 0 - название списка
     * 1 - название доавления/редактирования
     * @var array
     */
    protected $titles = [];

    public function __construct()
    {
        $this->crudService = CrudServiceFactory::makeCrudService(
            $this->getModel(),
            $this->getForm(),
            $this->isSortable
        );
    }

    /**
     * Templates
     */
    protected $templateIndex = 'core::common.index';
    protected $templateAdd = 'core::common.create';
    protected $templateEdit = 'core::common.edit';


    protected function getModel()
    {
        return $this->getClassName('Entities', '', 'Не указан класс модели.');

    }

    protected function getForm()
    {
        return $this->getClassName('Http\\Forms', 'Form', 'Не указан класс формы.');
    }

    protected function getTitle($section = 'index')
    {
        $titles = [
            'index' => $this->titles[0] ?? 'Список',
            'create' => 'Add '.($this->titles[1] ?? ''),
            'edit' => 'Edit '.($this->titles[1] ?? '')
        ];

        return $titles[$section];
    }


    protected function listFields()
    {
        return [
            'title' => [
                'name' => 'Name',
                'link' =>''
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                'outlist' => $this->outlist
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $route = action($this->getActionRoute('store'), $this->action_url_params);
        $form = $this->crudService->createForm($route);

        return view($this->templateAdd, [
            'form' => $form,
            'title' => $this->getTitle('create'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->crudService->store();
        flash()->success('Запись добавлена.');
        return $this->redirectToAction('index', $this->action_url_params);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->redirectToAction('edit', array_merge(['id' => $id], $this->action_url_params));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), array_merge(['id' => $id], $this->action_url_params));
        $form = $this->crudService->getEditForm($item, $route);

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->crudService->update($id);
       flash()->success('Запись обновлена.');

        return $this->redirectToAction('index', $this->action_url_params);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->crudService->destroy($id);
        flash()->success('Запись удалена');

        return $this->redirectToAction('index', $this->action_url_params);
    }

    protected function getController()
    {
        return '\\'.get_class($this);
    }

    protected function getActionRoute($action)
    {
        return $this->getController().'@'.$action;
    }

    protected function redirectToAction($action, $parameters = [], $status = '302')
    {
        return redirect()->action($this->getActionRoute($action), $parameters, $status);
    }

    private function getClassName($path, $suffix = '', $error_msg = 'Не указан класс')
    {
        $controller = new \ReflectionClass($this);
        $name = Str::singular(str_replace('Controller', '', $controller->getShortName()));
        $namespace = str_replace('Http\\Controllers', '', $controller->getNamespaceName());

        $class = $namespace.$path.'\\'.$name.$suffix;

        if(!class_exists($class)){
            throw new ClassNotSpecifiedException($error_msg);
        }

		return $class;
    }
	public function actionWithGroup(Request $request){
		switch ($request->post('action')){
			case 'delete':
				foreach ($request->post('items') as $item){
                    if($item) {
                        $this->crudService->destroy($item);
                        flash()->success('Записи удалены');
                    }
				}
				break;
		}
	}

    public function modalCreate(Request $request)
    {
        $item = $this->crudService->store();
        return $item;
    }

	public function dataTable(Request $request){
		$fields = $this->listFields();

		$model = $this->getModel()::query()->get();

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
                    return \Illuminate\Support\Facades\View::make('core::list_fields.' . $field['type'], compact('model', 'value', 'field', 'table', 'name', 'controller'));
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
