<?php

namespace Modules\Projects\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\CrudController;
use Modules\Projects\Entities\Project;

class ProjectsController extends CrudController
{
    protected $isSortable = true;
    protected $outlist = 'datatables';
    protected $templateIndex = 'projects::projects.index';
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
            'tokenName' => [
                'name' => 'Token Name',
                'type' => 'text'
            ],
            'contract' => [
                'name' => 'Contract',
                'type' => 'text'
            ],
            'projectLink' => [
                'name' => 'Project Link',
                'type' => 'text'
            ],
            'taskLink' => [
                'name' => 'Task Link',
                'type' => 'text'
            ],
            'has_game' => [
                'name' => 'Has Game',
                'type' => 'option',
                'choises' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
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
            'votes' => $votes
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
                WHERE project_id = ' . $id . ' 
                AND created_at BETWEEN ? AND ?
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
        $route = action($this->getActionRoute('update'), ['project' => $id]);
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
        $this->crudService->update($id);

        return $this->redirectToAction('index', 'page=' . $page);
    }

    public function destroy($id)
    {
        $this->crudService->getItemById($id);
        $this->crudService->destroy($id);

        return $this->redirectToAction('index', $this->action_url_params);
    }

    public function ajaxUpdate(Request $request, $id)
	{
		$model = Project::findOrFail($id);
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;
		$model->save();
	}
}
