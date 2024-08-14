<?php
namespace Modules\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class SettingMainForm extends Form
{
    public function buildForm()
    {
        $this
			->add('sitename', 'text', [
				'label' => 'Site name',
                'rules' => 'required|min:2|max:200|regex:/^[a-zA-Z0-9\s]+$/u',
			])
			->add('referral_percent', 'text', [
                'rules' => 'required|min:1|max:3|regex:/^[0-9]+$/u',
				'label' => 'Referral bonus value (%)'
			])
            ->add('api_secret', 'text', [
                'rules' => 'required',
                'label' => 'API secret'
            ])
            ->add('update_balance_time', 'text', [
                'rules' => 'required|min:1|max:2|regex:/^[0-9]+$/u',
                'label' => 'Update balance time (sec.)'
            ])
            ->add('update_balance_max_coins', 'text', [
                'rules' => 'required|min:1|max:5|regex:/^[0-9]+$/u',
                'label' => 'Max coins farm per/update balance time (value)'
            ])
            ->add('notify_to_play', 'select', [
                'label' => 'Notify to play',
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
            ])
            ->add('notify_image', 'image', [
                'label' => 'Notification image'
            ])
            ->add('notify_qty', 'text', [
                'label' => 'Notify players(per. 2 min)'
            ])
            ->add('notify_message', 'text', [
                'label' => 'Notification message'
            ])
		;
    }
}