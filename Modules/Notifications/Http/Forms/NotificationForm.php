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
                    0 => 'Notify if only registered but no activity',
                    1 => 'Notify if shit claimer never never used',
                    2 => 'Notify if shit claimer ready',
                    3 => 'Notify if project ready to vote',
                    4 => 'Notify if no activity 2 days',
                    5 => 'Notify if no activity 4 days',
                    6 => 'Notify if no activity 6 days',
                ]
            ])
            ->add('link', 'text', [
                'label' => 'Link'
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