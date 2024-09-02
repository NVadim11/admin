<?php

namespace Modules\Accounts\Http\Controllers;

use App\Services\RedisService;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CrudController;
use Modules\Accounts\Entities\Account;

class AccountsController extends CrudController
{
	protected $isSortable = false;

    protected $outlist = 'default';
//    protected $templateIndex = 'accounts::accounts.index';
	protected $templateEdit = 'accounts::accounts.edit';

    protected $titles = ['Accounts', 'account'];

    protected function listFields()
    {
        return [
            'parent_id' => [
                'name' => 'Parent ID',
                'type' => 'text'
            ],
            'id_telegram' => [
                'name' => 'Telegram ID',
                'type' => 'text'
            ],
            'is_premium' => [
                'name' => 'Telegram Premium',
                'type' => 'option',
                'choises' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ],
            'username' => [
                'name' => 'Username',
                'type' => 'text'
            ],
            'first_name' => [
                'name' => 'First Name',
                'type' => 'text'
            ],
            'last_name' => [
                'name' => 'Last Name',
                'type' => 'text'
            ],
            'wallet_address' => [
                'name' => 'Wallet Address',
                'type' => 'textarea'
            ],
            'wallet_balance' => [
                'name' => 'Wallet Balance',
                'type' => 'static'
            ],
            'active_referral' => [
                'name' => 'Is Active Referral',
                'type' => 'option',
                'choises' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ],
            'referrals_count' => [
                'name' => 'All Referrals',
                'type' => 'static'
            ],
            'active_referrals_count' => [
                'name' => 'Active Referrals',
                'type' => 'static'
            ],
            'referral_balance' => [
                'name' => 'Referral Balance',
                'type' => 'static'
            ],
            'referral_code' => [
                'name' => 'Referral Code',
                'type' => 'text'
            ],
            'energy' => [
                'name' => 'Energy',
                'type' => 'static'
            ],
            'sessions' => [
                'name' => 'Game sessions',
                'type' => 'text'
            ],
            'active_at' => [
                'name' => 'Can play at',
                'type' => 'date'
            ],
            'timezone' => [
                'name' => 'Timezone',
                'type' => 'static'
            ],
            'vis' => [
                'name' => 'Display',
                'type' => 'option',
                'choises' => [
                    1 => 'Yes',
                    0 => 'No'
                ]
            ],
            'created_at' => [
                'name' => 'Created at',
                'type' => 'static'
            ],
        ];
    }

    public function index(Request $request)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $route = action($this->getActionRoute('store'), $this->action_url_params);
        $this->page_size = isset($_GET['size']) ? $_GET['size'] : 10;
        if($request->get('search')) {
            $items = Account::where(function ($query) use ($request) {
                    $query->orWhere('id', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('parent_id', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('id_telegram', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('wallet_address', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('wallet_address', 'like', '%' . $request->get('search') . '%');
                })->orderBy('id', 'DESC')->paginate(10);
        } else {
            $params = $request->all();
            $query = Account::query();
            $fields = $this->listFields();
            foreach ($params as $key => $value) {
                if (!empty($value) && !empty($fields[$key])) {
                    $query->where($key, 'like', '%' . $value . '%');
                }
            }

            $items = $query->orderBy('id', 'DESC')->paginate(10);
        }

        $form = $this->crudService->createForm($route);

//        dd($this->listFields()); exit();
        return view($this->templateIndex, [
            'form' => $form,
            'items' => $items->appends($request->except('page')),
            'title' => $this->getTitle(),
            'add_new_title' => $this->getTitle('create'),
            'controller' => $this->getController(),
            'fields' => $this->listFields(),
            'sortable' => $this->isSortable,
            'outlist' => $this->outlist
        ]);
    }

	public function store(Request $request)
    {
        $item = $this->crudService->store();
        return $this->redirectToAction('index');
    }

    public function edit($id)
    {
        app()->setLocale(auth()->user()->locale ?? config('app.locale'));
        $request = request();
        $item = $this->crudService->getItemById($id);
        $route = action($this->getActionRoute('update'), ['account' => $id]);
        $form = $this->crudService->getEditForm($item, $route);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $params = $request->all();
        $query = Account::query();
        $fields = $this->listFields();
        foreach ($params as $key => $value) {
            if (!empty($value) && (!empty($fields[$key]) || $key == 'id')) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        $items = $query
            ->where('parent_id', $item->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view($this->templateEdit, [
            'form' => $form,
            'title' => $this->getTitle('edit'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
            'items' => $items->appends($request->except('page')),
            'item' => $item,
            'fields' => $this->listFields(),
            'sortable' => $this->isSortable,
            'outlist' => $this->outlist,
            'page' => $page
        ]);
    }

    public function update($id, Request $request)
    {
		$page = $request->post('page') ? $request->post('page') : 1;
        $item = $this->crudService->update($id);
        $redis = new RedisService();
        $redis->deleteIfExists($item->id_telegram);

        return $this->redirectToAction('index', 'page=' . $page);
    }

    public function destroy($id)
    {
        $item = $this->crudService->getItemById($id);
        $this->crudService->destroy($id);
        $redis = new RedisService();
        $redis->deleteIfExists($item->id_telegram);
        flash()->success('Запись удалена');

        return $this->redirectToAction('index', $this->action_url_params);
    }

    public function ajaxUpdate(Request $request, $id)
	{
		$model = Account::findOrFail($id);
		$name = $request->get('name');
		$value = $request->get('value');
		$model->$name = $value;
		$model->save();
        $redis = new RedisService();
        $redis->deleteIfExists($model->id_telegram);

	}
}
