<?php

namespace Modules\DailyQuests\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class DailyQuestForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
                'label' => 'Name(EN)'
            ])
            ->add('name_ru', 'text', [
                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
                'label' => 'Name(RU)'
            ])
            ->add('link', 'text', [
                'label' => 'Link'
            ])
            ->add('reward', 'text', [
                'rules' => 'required|regex:/^[0-9]+$/u',
                'label' => 'Reward'
            ])
            ->add('required_amount', 'text', [
                'rules' => 'nullable|regex:/^[0-9]+$/u',
                'label' => 'Required amount',
                'value' => 0
            ])
            ->add('required_referrals', 'text', [
                'rules' => 'nullable|regex:/^[0-9]+$/u',
                'label' => 'Required referrals',
                'value' => 0
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