<?php

namespace Modules\DailyQuests\Http\Controllers;

use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Core\Http\Controllers\CrudController;
use Modules\DailyQuests\Entities\DailyQuest;
use Modules\DailyQuests\Entities\DailyQuestRoom;
use Yajra\DataTables\DataTables;

abstract class DailyQuestCrudController extends CrudController
{
	protected $daily_quest;

	protected $templateIndex = 'daily_quests::common.index';
	protected $templateAdd = 'daily_quests::common.create';
	protected $templateEdit = 'daily_quests::common.edit';


	public function __construct(DailyQuest $daily_quest, Request $request)
	{
		$this->initData($request);
		parent::__construct();
	}

	protected function initData($request)
	{
		if( $request->route() && $request->route()->hasParameter('event') ){
			$this->daily_quest = DailyQuest::findOrFail($request->route()->parameter('event'));
			URL::defaults(['event' => $this->daily_quest->id]);
		}
	}

	abstract function getIdUrlParameterName();

	public function index(Request $request)
	{
		return parent::index($request)->with(['event' => $this->daily_quest]);
	}

	public function create()
	{
		$route = action($this->getActionRoute('store'), $this->action_url_params);

		$page = isset($_GET['page']) ? $_GET['page'] : 1;

		$form = $this->crudService->createForm($route, ['id_item' => $this->daily_quest->id]);

		return view($this->templateAdd, [
			'form' => $form,
			'title' => $this->getTitle('create'),
			'controller' => $this->getController(),
			'module_title' => $this->getTitle('index'),
			'daily_quest' => $this->daily_quest,
			'page' => $page
		]);
	}

    public function store(Request $request)
    {
        $page = $request->post('page') ? $request->post('page') : 1;
        $item = $this->crudService->store();

        $this->action_url_params['id'] = $item->id;
        $this->action_url_params['page'] = $page;

        Flash::success('Запись добавлена.');

        return $this->redirectToAction('edit', $this->action_url_params);
    }

	public function edit($id)
	{
		$id = \Route::current()->parameter($this->getIdUrlParameterName());

		return parent::edit($id)->with([
			'title' => $this->getTitle('edit'),
			'module_title' => $this->getTitle('index'),
			'daily_quest' => $this->daily_quest,
		]);
	}

	public function update($id, Request $request)
	{
		$id = \Route::current()->parameter($this->getIdUrlParameterName());

		return parent::update($id, $request);
	}

	public function destroy($id)
	{
		$id = \Route::current()->parameter($this->getIdUrlParameterName());

		return parent::destroy($id);
	}

	public function dataTable(Request $request){
		$fields = $this->listFields();

		$model = DailyQuestRoom::query()->where('daily_quest_id', $this->daily_quest->id)->get();

		$datatable = Datatables::of($model);

		foreach($fields as $name => $field){
			$datatable->addColumn($name, function($model) use ($name, $field) {
				$controller = $this->getController();
				$value = $model->$name;
				if(isset($field['type'])) {
					return view('core::list_fields.' . $field['type'], compact('model', 'value', 'name', 'field', 'controller'));
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

		$group = array('group' => '');
		$actions = array('actions' => '');

		array_push($fields, $group);
		array_push($fields, $actions);

		$datatable->rawColumns(collect($fields)->keys()->toArray());

		//			->toJson();
		return $datatable->make(true);
	}
	public function progressDataTable(Request $request){
		$fields = $this->listFields();

		$model = DailyQuestProgress::query()->where('daily_quest_id', $this->daily_quest->id)->get();

		$datatable = Datatables::of($model);

		foreach($fields as $name => $field){
			$datatable->addColumn($name, function($model) use ($name, $field) {
				$controller = $this->getController();
				$value = $model->$name;
				if(isset($field['type'])) {
					return view('core::list_fields.' . $field['type'], compact('model', 'value', 'name', 'field', 'controller'));
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

		$group = array('group' => '');
		$actions = array('actions' => '');

		array_push($fields, $group);
		array_push($fields, $actions);

		$datatable->rawColumns(collect($fields)->keys()->toArray());

		//			->toJson();
		return $datatable->make(true);
	}
}
