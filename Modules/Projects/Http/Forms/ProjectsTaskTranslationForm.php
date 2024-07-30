<?php

namespace Modules\Projects\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ProjectsTaskTranslationForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Name'
            ])
			->add('link', 'text', [
				'label' => 'Link'
			])
        ;
    }
}