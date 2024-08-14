<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class ConstructorType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'constructor';
    }

    public function getType()
    {
        return 'constructor';
    }

//    public function getDefaults()
//    {
//        return [
//            'zoom' => [
//                'new' => 10,
//                'exists' => 15
//            ]
//        ];
//    }


//    public function alterFieldValues(&$value)
//    {
//        $request = $this->parent->getRequest()->all();
//        $value = json_encode(['coord_x' => $request['coord_x'], 'coord_y' => $request['coord_y']]);
//    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        \Assets::addDirJs('/js/constructor/blocks/');
        \Assets::prependJs(['js/constructor/blocks_handler.js?1', 'js/constructor/helper.js?1']);
        \Assets::add('css/constructor.css');

        return parent::render($options, $showLabel, $showField, $showError);
    }
}