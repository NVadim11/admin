<?php

namespace Modules\ReferralTransactions\Http\Controllers;

use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Core\Http\Controllers\CrudController;
use Modules\ReferralTransactions\Entities\ReferralTransaction;
use Modules\ReferralTransactions\Entities\ReferralTransactionRoom;
use Yajra\DataTables\DataTables;

abstract class ReferralTransactionCrudController extends CrudController
{
	protected $referral_transaction;

	protected $templateIndex = 'referral_transactions::common.index';
	protected $templateAdd = 'referral_transactions::common.create';
	protected $templateEdit = 'referral_transactions::common.edit';


	public function __construct(ReferralTransaction $referral_transaction, Request $request)
	{
		$this->initData($request);
		parent::__construct();
	}

	protected function initData($request)
	{
		if( $request->route() && $request->route()->hasParameter('event') ){
			$this->referral_transaction = ReferralTransaction::findOrFail($request->route()->parameter('event'));
			URL::defaults(['event' => $this->referral_transaction->id]);
		}
	}

	abstract function getIdUrlParameterName();

	public function index(Request $request)
	{
		return parent::index($request)->with(['event' => $this->referral_transaction]);
	}

	public function create()
	{
		$route = action($this->getActionRoute('store'), $this->action_url_params);

		$page = isset($_GET['page']) ? $_GET['page'] : 1;

		$form = $this->crudService->createForm($route, ['id_item' => $this->referral_transaction->id]);

		return view($this->templateAdd, [
			'form' => $form,
			'title' => $this->getTitle('create'),
			'controller' => $this->getController(),
			'module_title' => $this->getTitle('index'),
			'referral_transaction' => $this->referral_transaction,
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
			'referral_transaction' => $this->referral_transaction,
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

		$model = ReferralTransactionRoom::query()->where('referral_transaction_id', $this->referral_transaction->id)->get();

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

		$model = ReferralTransactionProgress::query()->where('referral_transaction_id', $this->referral_transaction->id)->get();

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
