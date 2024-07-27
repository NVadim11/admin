<?php

namespace Modules\Core\Services\CrudService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Kris\LaravelFormBuilder\FormBuilder;

class CrudService
{
    private $model;
    private $sortable;
    private $formBuilder;
    private $form;

    public function __construct($model, $form_name, $sortable = false, FormBuilder $formBuilder)
    {
        $this->model = $model instanceof Model || $model instanceof Relation ? $model : new $model;
        $this->sortable = $sortable;
        $this->formBuilder = $formBuilder;
        $this->form = $form_name;
    }

    public function getItems($amount, $sort_value = 'id', $sort_order = 'DESC')
    {
        if($this->sortable){
            $model = $this->model->orderBy('pos', 'ASC');
        }else{
            $model = $this->model->orderBy($sort_value, $sort_order);
        }

        return $model->paginate($amount);
    }

	public function getItemsByCond($amount, $sort_value = 'id', $sort_order = 'DESC', $columns = [])
	{
		$this->columns = $columns;

		$model = $this->model->where(function ($query) {
			foreach ($this->columns as $name => $value)
				if($name != 'size' && isset($value))
					$query->where($name, '=', $value);
		})->orderBy($sort_value, $sort_order);

		return $model->paginate($amount);
	}

    public function createForm($route, $model = [])
    {
        return $this->formBuilder->create($this->form, [
            'method' => 'POST',
            'url' => $route,
            'model' => $model
        ]);
    }

    public function store()
    {
        $values = $this->getFormValues();

        if($this->sortable){
            $values['pos'] = $this->model->max('pos')+1;
        }

        return $this->model->create($values);
    }

    public function getItemById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getEditForm(Model $item, $route)
    {
        $values = $item->toArray();

        if(property_exists($item, 'translatedAttributes')){
            $values = array_merge($values, $item->getTranslationsArray());
        }

        return $this->formBuilder->create($this->form,
            [
                'method' => 'PATCH',
                'url' => $route,
                'model' => $values,
            ]);
    }

    public function update($id) : Model
    {
        $request = $this->getFormValues();
        $item = $this->model->find($id);

		$item->update($request);

        return $item;
    }

	public function destroy($id)
	{
		$item = $this->model->find($id);

		return $item->destroy($id);
	}

    public function getFormValues()
    {
        $form = $this->formBuilder->create($this->form);

        $form->redirectIfNotValid();
        $values = $form->getFieldValues();

        return $values;
    }
}