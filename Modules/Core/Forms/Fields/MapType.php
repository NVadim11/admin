<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MapType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'map';
    }

    public function getType()
    {
        return 'map';
    }
    public function getDefaults()
    {
        return [
            'zoom' => [
                'new' => 10,
                'exists' => 15
            ]
        ];
    }


    public function alterFieldValues(&$value)
    {
        $request = $this->parent->getRequest()->all();
        $value = json_encode(['coord_x' => $request['coord_x'], 'coord_y' => $request['coord_y']]);
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $this->setValue(json_decode($this->getValue(), true));

        return parent::render($options, $showLabel, $showField, $showError);
    }

}