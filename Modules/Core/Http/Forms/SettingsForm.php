<?php

namespace Modules\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class SettingsForm extends Form
{
    public function buildForm()
    {
        $this
			->add('main', 'tabform', [
				'label' => 'General',
				'class' => SettingMainForm::class
			])
        ;
    }
}
