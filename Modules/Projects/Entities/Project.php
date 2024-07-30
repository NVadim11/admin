<?php

namespace Modules\Projects\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Имя таблицы, можно опустить если имя соответствует конвенциям Laravel
    protected $table = "projects";

    // Поля, которые могут быть заполнены массово
    protected $fillable = [
        'name',
        'slug',
        'image',
        'contract_address',
        'ido_date',
        'presale_start',
        'presale_end',
        'telegram',
        'email',
        'ton_name',
        'ton_abbr',
        'ton_max_supply',
        'ton_revoke',
        'vote_total',
        'vote_24',
        'is_advertised',
        'is_verified',
        'place_order',
        'mark_id',
        'lucky_drop',
        'is_active',
        'ton_description',
        'ton_image',
        'ton_verification',
        'ton_decimals',
        'ton_holders_count',
        'ton_mintable',
        'price_usd',
        'site_link',
    ];

    protected $guarded = ['id'];

    public $timestamps = true;

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->orderBy('pos', 'ASC');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTasks()
    {
        return $this->hasMany(ProjectTask::class)->where('vis', 1)->orderBy('pos', 'ASC');
    }
}