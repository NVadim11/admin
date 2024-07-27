<?php

namespace Modules\Core\Http\Controllers;


class FeedbackController extends CrudController
{
    protected $titles = ['Сообщения', 'сообщения'];

    protected $templateIndex = 'core::feedback.index';

    protected function listFields()
    {
        return [
            'email' => [
                'title' => 'E-mail',
            ],
            'phone' => [
                'title' => 'Телефон',
            ],
            'created_at' => [
                'title' => 'Дата',
            ],
        ];
    }
}