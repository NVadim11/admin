<?php

namespace Modules\Notifications\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\CrudController;
use Modules\Notifications\Entities\Notification;
use Yajra\DataTables\DataTables;

class NotificationsController extends CrudController
{
	protected $isSortable = true;
    protected $outlist = 'datatables';
    protected $templateIndex = 'notifications::notifications.index';
	protected $templateEdit = 'notifications::notifications.edit';
    protected $titles = ['Notifications', 'Notification'];
    protected $sortOrder = 'ASC';
    protected $sortValue = 2;

    protected function listFields()
    {
        return [
            'name' => [
                'name' => 'Name',
                'type' => 'text'
            ],
//            'message' => [
//                'name' => 'Message',
//                'type' => 'textarea'
//            ],
            'image' => [
                'name' => 'Image',
                'type' => 'image'
            ],
            'type' => [
                'name' => 'Type',
                'type' => 'option',
                'choises' => [
                    0 => 'Notify if only registered but no activity',
                    1 => 'Notify if shit claimer never never used',
                    2 => 'Notify if shit claimer ready',
                    3 => 'Notify if project ready to vote',
                    4 => 'Notify if no activity 2 days',
                    5 => 'Notify if no activity 4 days',
                    6 => 'Notify if no activity 6 days',
                    7 => 'Notify if wallet not connected',
                ]
            ],
            'link' => [
                'name' => 'Link',
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
            'outlist' => $this->outlist
        ]);
    }

    public function edit($id)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));

        $request = new Request();
        $date = Carbon::now();
        $period = 'day';
        $votes = [];

        if ($request->get('stat')) {
            $period = $request->get('stat');
        }

        switch($period) {
            case "day":
                $days_count = 24;
                break;
            case "week":
                $days_count = 14;
                break;
            case "month":
                $days_count = 31;
                break;
            case "year":
                $days_count = 12;
                break;
        }

        for ($i = 0; $i < $days_count; $i++) {
            switch($period) {
                case "day":
                    $startOfDay = $date->copy()->format('Y-m-d H:00:00');
                    $endOfDay = $date->format('Y-m-d H:59:59');
                    $formattedDate = $date->format('d M H:00');
                    $formattedDay = $date->format('d M H:00');
                    break;
                case "week":
                    $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
                    $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('d M');
                    break;
                case "month":
                    $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
                    $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('d M');
                    break;
                case "year":
                    $startOfDay = $date->startOfDay()->format('Y-m-01');
                    $endOfDay = $date->endOfDay()->format('Y-m-31');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('M');
                    break;
            }

            $votesCount = DB::selectOne('
                SELECT COUNT(CASE WHEN client_id IS NOT NULL THEN 1 END) as count 
                FROM project_votes 
                WHERE created_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $votes[] = [
                'date' => $formattedDate,
                'day' => $formattedDay,
                'votes' => $votesCount
            ];

            switch($period) {
                case "day":
                    $date->subHour();
                    break;
                case "week":
                    $date->subDay();
                    break;
                case "month":
                    $date->subDay();
                    break;
                case "year":
                    $date->subMonth();
                    break;
            }
        }

        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), ['notification' => $id]);
        $form = $this->crudService->getEditForm($item, $route);
		$page = isset($_GET['page']) ? $_GET['page'] : 1;

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'item' => $item,
			'page' => $page,
            'votes' => $votes
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
		$model = Notification::findOrFail($id);
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
            return view('notifications::list_fields.actions', compact('model', 'controller'));
        });

        array_push($fields, 'id');
        array_push($fields, 'group');
        array_push($fields, 'actions');

        $datatable->rawColumns(collect($fields)->keys()->toArray());

        //			->toJson();
        return $datatable->make(true);
    }
}
