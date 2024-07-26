<?php

return [
    'defaults'        => [
        'wrapper_class'       => 'form-group mb-7 fv-row',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'form-label',
        'field_class'          => 'form-control form-control-sm',
        'help_block_class'    => 'help-block',
        'error_class'         => 'text-danger',
        'required_class'      => 'required',
        'select'              => ['field_class' => 'form-select form-select-sm']
        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //],
    ],
    // Templates
    'form'            => 'core::form_fields.form',
    'tabform'         => 'core::form_fields.form',
    'text'            => 'core::form_fields.text',
    'textarea'        => 'core::form_fields.textarea',
    'button'          => 'core::form_fields.button',
    'buttongroup'     => 'core::form_fields.buttongroup',
    'radio'           => 'core::form_fields.radio',
    'checkbox'        => 'core::form_fields.checkbox',
    'select'          => 'core::form_fields.select',
    'choice'          => 'core::form_fields.choice',
    'repeated'        => 'core::form_fields.repeated',
    'child_form'      => 'core::form_fields.child_form',
    'collection'      => 'core::form_fields.collection',
    'static'          => 'core::form_fields.static',
    'slug'            => 'core::form_fields.text',
    'date-picker'     => 'core::form_fields.text',
	'datetimepicker'=> 'core::form_fields.datetimepicker',
    'editor'          => 'core::form_fields.textarea',
    'tiny'            => 'core::form_fields.textarea',
    'image'           => 'core::form_fields.image',
    'file'            => 'core::form_fields.file',
    'map'             => 'core::form_fields.map',
    'constructor'     => 'core::form_fields.constructor',

    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix' => '',

    'default_namespace' => '',

    'custom_fields' => [
        'image'       => \Modules\Core\Forms\Fields\ImageType::class,
        'file'        => \Modules\Core\Forms\Fields\FileType::class,
        'checkbox'    => \Modules\Core\Forms\Fields\CheckboxType::class,
        'slug'        => \Modules\Core\Forms\Fields\SlugType::class,
        'tabform'     => \Modules\Core\Forms\Fields\TabFormType::class,
        'map'         => \Modules\Core\Forms\Fields\MapType::class,
        'editor'      => \Modules\Core\Forms\Fields\EditorType::class,
        'tiny'        => \Modules\Core\Forms\Fields\TinyType::class,
        'date-picker' => \Modules\Core\Forms\Fields\DatePickerType::class,
		'datetimepicker' => \Modules\Core\Forms\Fields\DateTimePickerType::class,
        'constructor' => \Modules\Core\Forms\Fields\ConstructorType::class,
//        'datetime' => App\Forms\Fields\Datetime::class
    ]
];
