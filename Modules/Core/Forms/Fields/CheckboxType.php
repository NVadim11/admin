<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CheckboxType extends FormField
{

    /**
     * @inheritdoc
     */
    protected $valueProperty = 'checked';

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'checkbox';
    }


    public function getDefaults()
    {
        return [
            'attr' => [
                'class' => 'form-check-input',
                'data-on-text' => 'Да',
                'data-off-text' => 'Нет'
            ],
            'value' => 1,
            'checked' => null,
        ];
    }

    public function alterFieldValues(&$value)
    {
        if(is_null($value)){
            $value = 0;
        }
    }

}