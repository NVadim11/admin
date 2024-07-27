<?php

namespace Modules\Core\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{

    public $fillable = ['name', 'value'];
    public $timestamps = false;
    private $params = [];

    public function updateParams(array $params)
    {
	        foreach ($params as $key=>$value) {
            $item = $this->firstOrCreate(['name'=>$key]);
            $item->value = $value;
            $item->save();
        }
    }

    public function getAllParams()
    {
        if(!$this->params){

/*
            $this->params = Cache::remember('site_setting', 180, function () {
                $params = [];
                $list = $this->newQuery()->get(['*'])->toArray();
                foreach ($list as $item) {
                    $params[$item['name']] = $item['value'];
                }

                return $this->allParams();
            });
*/

           $list = $this->newQuery()->get(['*'])->toArray();

           foreach ($list as $item) {
               $this->params[$item['name']] = $item['value'];
           }
        }

        return $this->params;
    }

    public function allParams()
    {
        $params = [];
        $list = $this->newQuery()->get(['*'])->toArray();
        foreach ($list as $item) {
            $params[$item['name']] = $item['value'];
        }

        return $params;
    }

    public function get($name)
    {
        $params = $this->getAllParams();

        return isset($params[$name]) ? $params[$name]:'';
    }

    public function getTranslated($name)
    {
        $params = $this->getAllParams();
        $lang = app()->getLocale();

        $l_name = $name.'_'.$lang;

        return isset($params[$l_name]) ? $params[$l_name]:'';
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            if(isset($model->slug)) {
                $model->slug = $model->slug . '-' . $model->id;
                $model->save();
            }
        });

        self::updated(function($model){});
        self::deleted(function($model){});
        self::updating(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists('game_data');
            $redis->deleteIfExists('site_data');
            $redis->deleteIfExists('bot_data');
        });
        self::deleting(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists('game_data');
            $redis->deleteIfExists('site_data');
            $redis->deleteIfExists('bot_data');
        });
    }
}
