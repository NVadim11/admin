<?php

namespace Modules\PartnersQuests\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\CrudController;
use Modules\PartnersQuests\Entities\PartnersQuest;
use Yajra\DataTables\DataTables;

class PartnersQuestsController extends CrudController
{
	protected $isSortable = true;
    protected $outlist = 'datatables';
    protected $templateIndex = 'partners_quests::partners_quests.index';
	protected $templateEdit = 'partners_quests::partners_quests.edit';
    protected $titles = ['Partners Quests', 'Partners Quest'];
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

	public function store(Request $request)
    {
        $item = $this->crudService->store();
        return $this->redirectToAction('index');
    }

    public function index(Request $request)
    {
        $date = Carbon::now();
        $days_count = 14;
        $gaming = [];

        for ($i = 0; $i < $days_count; $i++) {
            $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
            $formattedDate = $date->format('Y-m-d');
            $formattedDay = $date->format('d M');

            // Запрос для Telegram пользователей
            $telegramCount = DB::selectOne('
                SELECT COUNT(id) as count 
                FROM accounts_partners_quests 
                WHERE status = 1  
                AND updated_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $gaming[] = [
                'date' => $formattedDate,
                'day' => $formattedDay,
                'telegram' => $telegramCount
            ];

            // Переход на предыдущий день
            $date->subDay();
        }

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
            'gaming' => $gaming
        ]);
    }

    public function edit($id)
    {
        $date = Carbon::now();
        $days_count = 14;
        $gaming = [];

        for ($i = 0; $i < $days_count; $i++) {
            $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
            $formattedDate = $date->format('Y-m-d');
            $formattedDay = $date->format('d M');

            // Запрос для Telegram пользователей
            $completed = DB::selectOne('
                SELECT COUNT(id) as count 
                FROM accounts_partners_quests
                WHERE partners_quest_id = ' . $id . '
                AND status = 1  
                AND updated_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $gaming[] = [
                'date' => $formattedDate,
                'day' => $formattedDay,
                'completed' => $completed
            ];

            // Переход на предыдущий день
            $date->subDay();
        }

        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
//        $item = $this->crudService->getItemById($id)->load('partners')->load('certificates');
        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), ['partners_quest' => $id]);
        $form = $this->crudService->getEditForm($item, $route);
		$page = isset($_GET['page']) ? $_GET['page'] : 1;

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'item' => $item,
			'page' => $page,
            'gaming' => $gaming
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
		$model = PartnersQuest::findOrFail($id);
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
            return view('partners_quests::list_fields.actions', compact('model', 'controller'));
        });

        array_push($fields, 'id');
        array_push($fields, 'group');
        array_push($fields, 'actions');

        $datatable->rawColumns(collect($fields)->keys()->toArray());

        //			->toJson();
        return $datatable->make(true);
    }
}
