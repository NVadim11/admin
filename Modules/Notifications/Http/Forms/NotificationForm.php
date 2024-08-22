<?php

namespace Modules\Notifications\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class NotificationForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Name'
            ])
            ->add('message', 'textarea', [
                'label' => 'Message'
            ])
            ->add('image', 'image', [
                'label' => 'Image'
            ])
            ->add('type', 'select', [
                'label' => 'Display',
                'choices' => [
                    0 => 'Notify back to game after calldown',
                    1 => 'Notify if never playing'
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