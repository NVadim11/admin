<?php

namespace Modules\Core\Forms;


use Kris\LaravelFormBuilder\Form;

abstract class FormWithLanguage extends Form
{
    protected function languageBlocks()
    {
        $languages = config('translatable.locales');
        foreach ($languages as $k => $language) {
            $this->add($language, 'tabform', [
                'label' => strtoupper($language),
                'tab'   => $k,
                'class' => $this->getLanguageBlock()
            ]);
        }

        return $this;
    }

    abstract protected function getLanguageBlock();

}