<?php
namespace Modules\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class SettingBotForm extends Form
{
    public function buildForm()
    {
        $this
			->add('intro', 'textarea', [
				'label' => 'Intro'
			])
            ->add('rules', 'textarea', [
                'label' => 'Rules'
            ])
            ->add('referral', 'textarea', [
                'label' => 'Referral'
            ])
            ->add('stay_tuned', 'textarea', [
                'label' => 'Stay Tuned'
            ])
		;
    }
}