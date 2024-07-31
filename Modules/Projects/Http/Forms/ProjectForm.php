<?php

namespace Modules\Projects\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ProjectForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'max:500|nullable|regex:/^[a-zA-Z0-9\s\.\,\:\;\+\=\-\!\?\%]+$/u',
                'label' => 'Name'
            ])
            ->add('image', 'image', [
                'label' => 'Image'
            ])
            ->add('vote_total', 'text', [
                'label' => 'Votes Total'
            ])
            ->add('vote_24', 'text', [
                'label' => 'Votes 24'
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