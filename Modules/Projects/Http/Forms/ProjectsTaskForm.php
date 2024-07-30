<?php

namespace Modules\Projects\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ProjectsTaskForm extends Form
{
	public function buildForm()
	{
		$this
            ->add('name', 'text', [
                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
                'label' => 'Name'
            ])
            ->add('link', 'text', [
                'label' => 'Link'
            ])
            ->add('reward', 'text', [
                'rules' => 'required|regex:/^[0-9]+$/u',
                'label' => 'Reward'
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