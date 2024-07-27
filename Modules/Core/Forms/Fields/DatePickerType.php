<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class DatePickerType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'text';
    }

    public function getType()
    {
        return 'text';
    }

    public function getDefaults()
    {
        return [
            'default_value' => date('Y-m-d'),
            'attr' => [
                'class' => 'form-control form-control-inline input-medium date-picker',
                'readonly' => 'readonly',
            ]
        ];
    }

}