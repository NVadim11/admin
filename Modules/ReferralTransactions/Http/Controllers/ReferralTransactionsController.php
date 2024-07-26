<?php

namespace Modules\ReferralTransactions\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CrudController;
use Modules\ReferralTransactions\Entities\ReferralTransaction;
use Yajra\DataTables\DataTables;

class ReferralTransactionsController extends CrudController
{
	protected $isSortable = true;
    protected $outlist = 'datatables';
    protected $templateIndex = 'referral_transactions::referral_transactions.index';
	protected $templateEdit = 'referral_transactions::referral_transactions.edit';
    protected $titles = ['Referral Conditions', 'Condition'];
    protected $sortOrder = 'ASC';
    protected $sortValue = 2;

    protected function listFields()
    {
        return [
            'name' => [
                'name' => 'Name(EN)',
                'type' => 'text'
            ],
            'name_ru' => [
                'name' => 'Name(RU)',
                'type' => 'text'
            ],
            'required_referrals' => [
                'name' => 'Required referrals',
                'type' => 'text'
            ],
            'reward' => [
                'name' => 'Referral Reward %',
                'type' => 'text'
            ],
            'vis' => [
                'name' => 'Active',
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

    public function edit($id)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
//        $item = $this->crudService->getItemById($id)->load('partners')->load('certificates');
        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), ['referral_transaction' => $id]);
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
        $item = $this->crudService->update($id);

        return $this->redirectToAction('index', 'page=' . $page);
    }

    public function ajaxUpdate(Request $request, $id)
	{
		$model = ReferralTransaction::findOrFail($id);
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;
		$model->save();
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
//            return view('core::list_fields.group', compact('model'));
        });

        $datatable->addColumn('action', function($model){
            $controller = $this->getController();
            return view('referral_transactions::list_fields.actions', compact('model', 'controller'));
        });

        array_push($fields, 'id');
        array_push($fields, 'group');
        array_push($fields, 'actions');

        $datatable->rawColumns(collect($fields)->keys()->toArray());

        //			->toJson();
        return $datatable->make(true);
    }
}
