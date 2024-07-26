<?php

namespace Modules\Accounts\Http\Controllers;

use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Core\Http\Controllers\CrudController;
use Modules\Accounts\Entities\Account;
use Modules\Accounts\Entities\AccountRoom;
use Yajra\DataTables\DataTables;

abstract class AccountCrudController extends CrudController
{
	protected $account;

	protected $templateIndex = 'accounts::common.index';
	protected $templateAdd = 'accounts::common.create';
	protected $templateEdit = 'accounts::common.edit';


	public function __construct(Account $account, Request $request)
	{
		$this->initData($request);
		parent::__construct();
	}

	protected function initData($request)
	{
		if( $request->route() && $request->route()->hasParameter('event') ){
			$this->account = Account::findOrFail($request->route()->parameter('event'));
			URL::defaults(['event' => $this->account->id]);
		}
	}

	abstract function getIdUrlParameterName();

	public function index(Request $request)
	{
		return parent::index($request)->with(['event' => $this->account]);
	}

	public function create()
	{
		$route = action($this->getActionRoute('store'), $this->action_url_params);

		$page = isset($_GET['page']) ? $_GET['page'] : 1;

		$form = $this->crudService->createForm($route, ['id_item' => $this->account->id]);

		return view($this->templateAdd, [
			'form' => $form,
			'title' => $this->getTitle('create'),
			'controller' => $this->getController(),
			'module_title' => $this->getTitle('index'),
			'account' => $this->account,
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
			'account' => $this->account,
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

		$model = AccountRoom::query()->where('account_id', $this->account->id)->get();

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

		$model = AccountProgress::query()->where('account_id', $this->account->id)->get();

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
