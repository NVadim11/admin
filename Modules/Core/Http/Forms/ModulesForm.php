<?php

namespace Modules\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Core\Repositories\ModulesRepository;

class ModulesForm extends Form
{
    private $modules;

    public function __construct(ModulesRepository $modules)
    {
        $this->modules = $modules;
    }
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'rules' => 'required|min:3',
                'label' => 'Название'
            ])
            ->add('name', 'text', [
                'rules' => 'required|min:3',
                'label' => 'Роут'
            ])
            ->add('section', 'select', [
                'choices' => $this->modules->sections(true),
                'label' => 'Секция'
            ])
            ->add('description', 'textarea', [
                'label' => 'Описание'
            ])
            ->add('hidden', 'checkbox', [
                'value' => 1,
                'label' => 'Скрытый',
                'attr' => [
                    'class' => 'make-switch',
                    'data-on-text' => 'Да',
                    'data-off-text' => 'Нет'
                ]
            ])
        ;
    }
}
