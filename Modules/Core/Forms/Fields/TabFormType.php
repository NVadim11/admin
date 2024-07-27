<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\ChildFormType;

class TabFormType extends ChildFormType
{

    public function getDefaults()
    {
        $default =  [
            'label_show' => false,
            'tab' => true,
        ];

        return array_merge(parent::getDefaults(), $default);
    }

}