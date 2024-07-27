<?php

namespace Modules\Core\Repositories;


use Modules\Core\Entities\Modules;
use Modules\Core\Entities\User;

class ModulesRepository
{
    private $model;

    public function __construct(Modules $modules)
    {
        $this->model = $modules;
    }

    public function getAllModules()
    {
        $items = Modules::orderBy('title')->get();

        return $this->getList($items);
    }

    public function getUserModules(User $user)
    {
        if($user->is_admin()){
            $items = $this->getAllModules();
        }else{
            $modules = $user->modules;

            foreach ($user->groups->load('modules') as $item) {
                if($item->modules->isNotEmpty()){
                    $modules = $modules->merge($item->modules);
                }
            }

            $items = $this->getList($modules);
        }

        return $items;
    }

    public function sections($short = false)
    {
        $items = [
            'modules' => ['name' => 'Modules', 'icon' => 'triangle'],
            'home' => ['name' => 'Home', 'icon' => 'home'],
            'game' => ['name' => 'Game', 'icon' => 'rocket'],
            'accesses' => ['name' => 'Profiles', 'icon' => 'profile-user'],
            'tools' => ['name' => 'Tools', 'icon' => 'gear'],
            'referrals' => ['name' => 'Referrals', 'icon' => 'briefcase'],
        ];

        if($short){
            foreach ($items as &$item){
                $item = $item['name'];
            }
        }

        return $items;
    }

    private function getList($items)
    {
        $modules = [];
        foreach ($items as $item){
        	if(!$item->hidden) {
				$modules[$item->section][] = $item;
			}
        }

        return $modules;
    }
}