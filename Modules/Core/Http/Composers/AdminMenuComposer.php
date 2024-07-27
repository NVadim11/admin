<?php

namespace Modules\Core\Http\Composers;

use Modules\Core\Repositories\ModulesRepository;
use Illuminate\Contracts\View\View;

class AdminMenuComposer
{
    private $modules;

    public function __construct(ModulesRepository $modules)
    {
        $this->modules = $modules;
    }

    public function compose(View $view)
    {
        $view->with('modules', $this->modules->getUserModules(auth()->user()));
        $view->with('sections', $this->modules->sections());
    }

}