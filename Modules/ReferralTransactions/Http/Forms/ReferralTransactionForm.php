<?php

namespace Modules\ReferralTransactions\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ReferralTransactionForm extends Form
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
            ->add('reward', 'text', [
                'rules' => 'required|regex:/^[0-9]+$/u',
                'label' => 'Referral Reward %'
            ])
            ->add('required_referrals', 'text', [
                'rules' => 'nullable|regex:/^[0-9]+$/u',
                'label' => 'Required referrals',
                'value' => 0
            ])
            ->add('vis', 'select', [
                'label' => 'Active',
                'choices' => [
                    1 => 'Yes',
                    0 => 'No'
                ]
            ])
        ;
    }
}