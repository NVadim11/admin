<?php

namespace Modules\Accounts\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AccountsTranslationForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Title'
            ])
            ->add('subtitle', 'text', [
                'label' => 'Подзаголовок'
            ])
            ->add('preview', 'text', [
                'label' => 'Превью текст'
            ])
            ->add('descr', 'editor', [
                'label' => 'Описание'
            ])
        ;
    }
}