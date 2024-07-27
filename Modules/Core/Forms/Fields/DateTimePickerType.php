<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class DateTimePickerType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'datetimepicker';
    }

    public function getType()
    {
        return 'datetimepicker';
    }

    public function getDefaults()
    {
        return [
            'default_value' => date('d.m.Y H:i'),
            'attr' => [
                'class' => 'form-control form-control-inline input-medium datetimepicker'
            ]
        ];
    }

    public function setValue($value) {
        $this->options['value'] = !empty($value) ? date('d.m.Y H:i:s', $value) : '';
    }

    public function alterFieldValues(&$value)
    {
        $value = !empty($value[0]) ? strtotime($value[0]) : '';
    }

}