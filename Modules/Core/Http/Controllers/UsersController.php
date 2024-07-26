<?php

namespace Modules\Core\Http\Controllers;

use Caffeinated\Flash\Facades\Flash;
use Modules\Core\Http\Forms\UsersForm;
use Modules\Core\Entities\User;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Core\Services\UserService;
use Da\TwoFA\Service\TOTPSecretKeyUriGeneratorService;
use Da\TwoFA\Service\QrCodeDataUriGeneratorService;
use Da\TwoFA\Manager;

/**
 * Class UsersController
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controller = $this->getController();
        $users = User::where('id', '<>', '1')->get();

        return view('core::users.index', compact('users', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $controller = $this->getController();
        $form = $formBuilder->create(UsersForm::class, [
            'method' => 'POST',
            'url' => route('users.store'),
        ], ['is_admin' => $this->is_admin()]);

        return view('core::users.create', compact('form', 'controller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manager = new Manager();
        $form = $this->form(UsersForm::class, [], ['is_admin' => $this->is_admin()]);
        $form->validate(['password' => 'required|confirmed|min:3']);
        $form->validate(['email' => 'unique:users,email,' . auth()->user()->id]);
        $form->redirectIfNotValid();
		$form->getFieldValues();

		$data = $request->all();
		if(isset($data['avatar'])){
			$data['avatar'] = 'images/' . $request->avatar->hashName();
		}

        $data['auth_verify_secret'] = $manager->generateSecretKey();

		$user = User::create($data);
        $user->modules()->sync($request['modules']);
        $user->groups()->sync($request['groups']);

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('users.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, FormBuilder $formBuilder)
    {
        $module_title = $this->getTitle('index');
        $controller = $this->getController();
        $form = $formBuilder->create(UsersForm::class,
            [
                'method' => 'PATCH',
                'url' => route('users.update', $user),
                'model' => $user->load(['modules', 'groups'])->toArray()
            ], ['is_admin' => $this->is_admin()]);

        $totpUri = (new TOTPSecretKeyUriGeneratorService($_SERVER['HTTP_HOST'], $user->login, $user->auth_verify_secret))->run();
        $uri = (new QrCodeDataUriGeneratorService($totpUri))->run();

        return view('core::users.edit', compact('form', 'uri', 'controller', 'module_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $manager = new Manager();
        $form = $this->form(UsersForm::class, [], ['is_admin' => $this->is_admin()]);
        $form->validate(['email' => 'unique:users,email,' . $user->id]);
        $form->redirectIfNotValid();
        $form->getFieldValues();
        if(!$request['password']){
            unset($request['password']);
        }

        $data = $request->all();

        if(isset($data['avatar'])){
			$data['avatar'] = 'images/' . $request->avatar->hashName();
		}

        $data['full_access'] = isset($data['full_access']) ? 1 : 0;
        $data['auth_verify'] = isset($data['auth_verify']) ? 1 : 0;
        $data['auth_verify_secret'] = $user->auth_verify_secret ? $user->auth_verify_secret : $manager->generateSecretKey();

        $user->update($data);

        $user->modules()->sync($request['modules']);
        $user->groups()->sync($request['groups']);

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, UserService $service)
    {
        try{
            $service->deleteUser($user);
        }catch (\LogicException $e){
            Flash::error($e->getMessage());
        }

        return redirect()->route('users.index');
    }

    protected function getController()
    {
        return '\\'.get_class($this);
    }

    protected function getTitle($section = 'index')
    {
        $titles = [
            'index' => $this->titles[0] ?? 'Users',
            'create' => 'Add '.($this->titles[1] ?? ''),
            'edit' => 'Edit '.($this->titles[1] ?? '')
        ];

        return $titles[$section];
    }

    private function is_admin()
    {
        return auth()->user()->is_admin();
    }
}
