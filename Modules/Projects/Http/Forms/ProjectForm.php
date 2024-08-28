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
            ->add('tokenName', 'text', [
                'label' => 'Token Name'
            ])
            ->add('contract', 'text', [
                'label' => 'Contract'
            ])
            ->add('projectLink', 'text', [
                'label' => 'Project Link'
            ])
            ->add('taskLink', 'text', [
                'label' => 'Task Link'
            ])
            ->add('has_game', 'select', [
                'label' => 'Has Game',
                'choices' => [
                    0 => 'No',
                    1 => 'Yes'
                ]
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