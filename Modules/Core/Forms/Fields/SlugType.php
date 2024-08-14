<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Modules\Core\Services\TranslitServices;
use Illuminate\Support\Arr;

class SlugType extends FormField
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
            'source' => 'name',
        ];
    }

    public function alterFieldValues(&$value)
    {
        $request = $this->parent->getRequest()->all();
        $source = $this->getOption('source');
    
        $value = isset($request['link']) && $request['link'] ? $request['link'] : (isset($request['slug']) && $request['slug'] ? $request['slug'] : '');
        $value = $value ? $value : $this->stringToSlug(Arr::get($request['uk'], $source));
    }

    protected function stringToSlug($value)
    {
        return app()->make(TranslitServices::class)->toUrl($value);
    }

}