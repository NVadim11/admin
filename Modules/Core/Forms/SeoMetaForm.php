<?php
/**
 * Created by Developer.
 * User: Dmitry S.
 * Date: 30.11.2017
 * Time: 12:53
 */

namespace Modules\Core\Forms;


use Kris\LaravelFormBuilder\Form;

class SeoMetaForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('seo_title', 'text', [
                'label' => 'SEO title'
            ])
            ->add('seo_description', 'textarea', [
                'label' => 'SEO description'
            ])
            ->add('seo_keywords', 'textarea', [
                'label' => 'SEO keywords'
            ])
            ;
    }
}