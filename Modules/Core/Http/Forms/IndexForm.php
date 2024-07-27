<?php

namespace Modules\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class IndexForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('bot', 'tabform', [
                'label' => 'Telegram Bot',
                'class' => SettingBotForm::class
            ])
        ;
    }
}
