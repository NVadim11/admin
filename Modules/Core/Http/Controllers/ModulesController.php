<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Http\Forms\ModulesForm;
use Modules\Core\Entities\Modules;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class ModulesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Modules::all();

        return view('core::modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ModulesForm::class, [
            'method' => 'POST',
            'url' => route('modules.store')
        ]);

        return view('core::modules.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->form(ModulesForm::class);

        $form->redirectIfNotValid();
		$form->getFieldValues();

//        Modules::create($form->getFieldValues());
		Modules::create($request->all());

        return redirect()->route('modules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('modules.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Modules $module
     * @param FormBuilder $formBuilder
     *
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function edit(Modules $module, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ModulesForm::class, [
            'method' => 'PATCH',
            'url' => route('modules.update', $module),
            'model' => $module->toArray(),
        ]);

        return view('core::modules.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     * @internal param Modules $module
     */
    public function update(Modules $module, Request $request)
    {
        $form = $this->form(ModulesForm::class);

        $form->redirectIfNotValid();
		$form->getFieldValues();

//        $module->update($form->getFieldValues());
		$module->update($request->all());

        return redirect()->route('modules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
