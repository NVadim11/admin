<?php

namespace Modules\Core\Http\Forms;

use Modules\Core\Entities\Group;
use Modules\Core\Entities\Modules;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Arr;

class UsersForm extends Form
{
    public function buildForm()
    {
        $locales = [];
        if(!empty(config('translatable.locales'))) {
            foreach(config('translatable.locales') as $locale) {
                $locales[$locale] = $locale;
            }
        }
        $this
            ->add('avatar', 'image', [
                'label' => 'Avatar',
                'rules' => 'max:2048|mimes:jpg,jpeg,png,gif',
                'aside' => 1,
            ])
            ->add('name', 'text', [
                'rules' => 'required|min:3',
                'label' => 'Name'
            ])
            ->add('login', 'text', [
                'rules' => 'required|min:3',
                'label' => 'Login'
            ])
            ->add('email', 'email', [
                'rules' => 'required|email',
                'label' => 'E-mail'
            ])
            ->add('password', 'repeated', [
                'type'           => 'password',
                'value'          => '',
                'first_options'  => [
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Repeat password'
                ]
            ])
            ->add('modules', 'entity', [
                'label'    => 'Modules',
                'class'    => Modules::class,
                'property' => 'title',
                'multiple' => true,
                'selected' => function ($data) {
                    return $data ? Arr::pluck($data, 'id') : [];
                },
                'attr'     => [
                    'class' => 'form-select mb-2 select2-hidden-accessible',
                    'data-control' => 'select2'
                ]
            ])
            ->add('groups', 'entity', [
                'label'    => 'Groups',
                'class'    => Group::class,
                'multiple' => true,
                'property' => 'title',
                'selected' => function ($data) {
                    return $data ? Arr::pluck($data, 'id') : [];
                },
                'attr'     => [
                    'class' => 'form-select mb-2 select2-hidden-accessible',
                    'data-control' => 'select2'
                ]
            ])
            ->add('locale', 'select', [
                'label' => 'Localization',
                'attr' => [
                    'data-control' => 'select2',
                    'data-hide-search' => 'true'
                ],
                'aside' => 1,
                'choices' => $locales
            ]);

        if ($this->getData('is_admin') === true) {
            $this->add('full_access', 'checkbox', [
                'label' => 'Admin',
            ]);
//            $this->add('notify', 'checkbox', [
//                'label' => 'Отправлять уведомления'
//            ]);
        }
        $this->add('auth_verify', 'checkbox', [
            'label' => 'Two fact auth'
        ]);
    }
}
