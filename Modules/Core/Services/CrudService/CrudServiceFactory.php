<?php

namespace Modules\Core\Services\CrudService;


class CrudServiceFactory
{
    public static function makeCrudService($model, $form_name, $sortable)
    {
        return \App::make(CrudService::class, [
            'model' => $model,
            'sortable' => $sortable,
            'form_name' => $form_name
        ]);
    }
}