<?php

namespace Modules\Core\Http\Forms;

use Modules\Core\Entities\Modules;
use Kris\LaravelFormBuilder\Form;
use Modules\Core\Entities\User;
use Illuminate\Support\Arr;

class GroupForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'rules' => 'required|min:3',
                'label' => 'Name'
            ])
            ->add('text', 'textarea', [
                'label' => 'Description'
            ])

            ->add('users',  'entity', [
                'label' => 'Users',
                'class' => User::class,
				'query_builder' => function (User $user) {
					return $user::where('id', '<>', '1')->get();
				},
                'multiple' => true,
                'selected' => function ($data) {
                    return $data ? Arr::pluck($data, 'id') : [];
                },
                'attr' => [
                    'class' => 'form-select mb-2 select2-hidden-accessible',
                    'data-control' => 'select2'
                ]
            ])

            ->add('modules',  'entity', [
                'label' => 'Modules',
                'class' => Modules::class,
                'property' => 'title',
                'multiple' => true,
                'selected' => function ($data) {
                    return $data ? Arr::pluck($data, 'id') : [];
                },
                'attr' => [
                    'class' => 'form-select mb-2 select2-hidden-accessible',
                    'data-control' => 'select2'
                ]
            ]);
    }
}
