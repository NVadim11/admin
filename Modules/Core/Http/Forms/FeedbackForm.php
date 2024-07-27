<?php
/**
 * Created by Developer.
 * User: Dmitry S.
 * Date: 19.11.2017
 * Time: 19:54
 */

namespace Modules\Core\Http\Forms;


use Kris\LaravelFormBuilder\Form;

class FeedbackForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'ФИО'
            ])
            ->add('phone', 'text', [
                'label' => 'Телефон'
            ])
            ->add('email', 'text', [
                'label' => 'E-mail'
            ])
            ->add('msg', 'textarea', [
                'label' => 'Сообщение'
            ])
            ;
    }
}