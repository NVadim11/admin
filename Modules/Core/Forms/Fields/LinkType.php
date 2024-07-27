<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Modules\Core\Services\TranslitServices;

class LinkType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'link';
    }

    public function getType()
    {
        return 'link';
    }

    public function getDefaults()
    {
        return [
            'source' => 'name',
        ];
    }

//    public function alterFieldValues(&$value)
//    {
//        $request = $this->parent->getRequest()->all();
//        $source = $this->getOption('source');
//
//        $value = $request['slug'] ?? $this->stringToSlug(array_get($request['ru'], $source));
//    }
//
//    protected function stringToSlug($value)
//    {
//        return app()->make(TranslitServices::class)->toUrl($value);
//    }

}