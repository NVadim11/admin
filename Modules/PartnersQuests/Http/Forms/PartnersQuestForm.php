<?php

namespace Modules\PartnersQuests\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class PartnersQuestForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
                'label' => 'Name(EN)'
            ])
//            ->add('name_ru', 'text', [
//                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
//                'label' => 'Name(RU)'
//            ])
            ->add('link', 'text', [
                'label' => 'Link'
            ])
            ->add('reward', 'text', [
                'rules' => 'required|regex:/^[0-9]+$/u',
                'label' => 'Reward'
            ])
            ->add('code', 'text', [
                'label' => 'Code'
            ])
            ->add('type', 'select', [
                'label' => 'Type',
                'choices' => [
                    0 => 'Regular',
                    1 => 'Base'
                ]
            ])
            ->add('vis', 'select', [
                'label' => 'Display',
                'choices' => [
                    1 => 'Yes',
                    0 => 'No'
                ]
            ])
        ;
    }
}