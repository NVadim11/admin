<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Http\Forms\SettingsForm;
use Modules\Core\Entities\Settings;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class SettingsController extends Controller
{
    use FormBuilderTrait;

    public function index(Settings $settings, FormBuilder $form_builder)
    {
        $values = $settings->allParams();
		$values['main'] = [
			'sitename' => $values['sitename'] ?? '',
            'api_secret' => $values['api_secret'] ?? '',
            'referral_percent' => $values['referral_percent'] ?? '',
            'update_balance_time' => $values['update_balance_time'] ?? '',
            'update_balance_max_coins' => $values['update_balance_max_coins'] ?? '',
            'notify_to_play' => $values['notify_to_play'] ?? '',
            'notify_qty' => $values['notify_qty'] ?? '',
            'notify_image' => $values['notify_image'] ?? '',
            'notify_message' => $values['notify_message'] ?? '',
		];

        $form = $form_builder->create(SettingsForm::class,[
            'method' => 'POST',
            'url' => route('settings.store'),
            'model' => $values
        ]);

        return view('core::settings.index', compact('form'));
    }

    public function store(Settings $settings)
    {
        $form = $this->form(SettingsForm::class);

        $form->redirectIfNotValid();

        $values = $form->getFieldValues();

        $main = $values['main'];
        unset($values['main']);
        $values += $main;

        $settings->updateParams($values);

        return redirect()->route('settings.index');
    }
}
