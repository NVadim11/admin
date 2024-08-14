<?php

namespace Modules\Core\Http\Controllers;


use Caffeinated\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Core\Exceptions\ClassNotSpecifiedException;
use Modules\Core\Services\CrudService\CrudServiceFactory;
use Modules\Core\Services\CrudService\CrudTreeTransformer;

abstract class CrudTreeController extends Controller
{

    private $form_builder;
    /**
     * 0 - название списка
     * 1 - название доавления/редактирования
     * @var array
     */
    protected $titles = [];

    /**
     * Templates
     */
    protected $templateIndex = 'core::common.tree.index';
    protected $templateAdd = 'core::common.create';
    protected $templateEdit = 'core::common.edit';

    public function __construct(FormBuilder $form_builder)
    {
        $this->form_builder = $form_builder;
    }

    protected function getTitle($section = 'index')
    {
        $titles = [
            'index' => $this->titles[0] ?? 'Список',
            'create' => 'Добавление '.($this->titles[1] ?? ''),
            'edit' => 'Редактирование '.($this->titles[1] ?? '')
        ];

        return $titles[$section];
    }

    protected function getModel()
    {
        return $this->getClassName('Entities', '', 'Не указан класс модели.');

    }

    protected function getForm()
    {
        return $this->getClassName('Http\\Forms', 'Form', 'Не указан класс формы.');
    }

    public function index()
    {
        return view($this->templateIndex, [
            'title' => $this->getTitle(),
            'controller' => $this->getController(),
        ]);
    }

    public function list(Request $request, CrudTreeTransformer $transformer)
    {
        if(!$request->isXmlHttpRequest()){
            abort(404);
        }

        $model = $this->getModel();
        $items = $model::whereNull('parent_id')->with('childrenRecursive')->get();

        return $transformer->transform($items);
    }

    public function create($parent_id = null)
    {
        $route = action($this->getActionRoute('store'), $parent_id);

        $form = $this->form_builder->create($this->getForm(), [
            'method' => 'POST',
            'url' => $route,
        ]);

        return view($this->templateAdd, [
            'form' => $form,
            'title' => $this->getTitle('create'),
            'module_title' => $this->getTitle('index'),
            'controller' => $this->getController(),
        ]);
    }

    public function store($parent_id = null)
    {
        $values = $this->getFormValues();
        $values['parent_id'] = $parent_id;

        Regulation::create($values);

        Flash::success('Запись добавлена.');

        return $this->redirectToAction('index');
    }

    public function edit($id)
    {
        $item = Regulation::findOrFail($id);

        $form = $this->form_builder->create(RegulationForm::class, [
            'method' => 'PATCH',
            'url' => route('regulations.update', $id),
            'model' => $this->getModelData($item)
        ]);

        return view('regulations::edit', [
            'form' => $form,
            'title' => 'Редактирование документа',
            'module_title' => 'Нормативные документы',
            'controller' => '\\'.self::class,
            'item' => $item,
        ]);
    }

    public function update($id)
    {
        $values = $this->getFormValues();

        $item = Regulation::findOrFail($id);
        $item->update($values);

        Flash::success('Запись обновлена.');

        return redirect(route('regulations.index'));
    }

    public function destroy($id)
    {
        Regulation::findOrFail($id)->delete();


        return ['sux' => 1];
    }

    private function getModelData(Model $model)
    {
        $values = $model->toArray();
        if(property_exists($model, 'translatedAttributes')){
            $values = array_merge($values, $model->getTranslationsArray());
        }

        return $values;
    }

    private function getFormValues()
    {
        $form = $this->form_builder->create($this->getForm());

        $form->redirectIfNotValid();
        return $form->getFieldValues();
    }
}
