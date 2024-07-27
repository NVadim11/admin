<?php

namespace Modules\Accounts\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AccountForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('username', 'text', [
                'label' => 'Username'
            ])
            ->add('first_name', 'text', [
                'label' => 'First Name'
            ])
            ->add('last_name', 'text', [
                'label' => 'Last Name'
            ])
            ->add('wallet_address', 'text', [
                'label' => 'Wallet Address'
            ])
            ->add('id_telegram', 'text', [
                'label' => 'Telegram ID'
            ])
            ->add('is_premium', 'select', [
                'label' => 'Telegram Premium',
                'aside' => 1,
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ])
            ->add('wallet_balance', 'text', [
                'label' => 'Wallet Balance',
                'default_value' => 0,
                'rules' => 'min:1|regex:/^[0-9]+$/u',
                'aside' => 1
            ])
            ->add('referral_balance', 'text', [
                'label' => 'Referral Balance',
                'default_value' => 0,
                'rules' => 'min:1|regex:/^[0-9]+$/u',
                'aside' => 1
            ])
            ->add('energy', 'text', [
                'label' => 'Energy',
                'default_value' => 0,
                'rules' => 'min:1|regex:/^[0-9]+$/u',
                'aside' => 1
            ])
            ->add('sessions', 'text', [
                'label' => 'Game sessions',
                'default_value' => 0,
                'rules' => 'min:1|regex:/^[0-9]+$/u',
                'aside' => 1
            ])
            ->add('active_at', 'datetimepicker', [
                'label' => 'Can play at',
                'aside' => 1
            ])
            ->add('language_code', 'static', [
                'label' => 'Language',
                'aside' => 1
            ])
            ->add('is_bot', 'select', [
                'label' => 'Is bot',
                'aside' => 1,
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ])
            ->add('active_referral', 'select', [
                'label' => 'Active Referral',
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ])
            ->add('timezone', 'text', [
                'label' => 'Timezone',
                'aside' => 1
            ])
            ->add('twitter', 'select', [
                'label' => 'Twitter',
                'choices' => [
                    0 => 'Not passed',
                    1 => 'Passed'
                ]
            ])
            ->add('tg_chat', 'select', [
                'label' => 'Telegram chat',
                'choices' => [
                    0 => 'Not passed',
                    1 => 'Passed'
                ]
            ])
            ->add('tg_channel', 'select', [
                'label' => 'Telegram channel',
                'choices' => [
                    0 => 'Not passed',
                    1 => 'Passed'
                ]
            ])
            ->add('website', 'select', [
                'label' => 'Website',
                'choices' => [
                    0 => 'Not passed',
                    1 => 'Passed'
                ]
            ])
            ->add('referral_code', 'text', [
                'label' => 'Referral Code'
            ])
        ;
    }
}