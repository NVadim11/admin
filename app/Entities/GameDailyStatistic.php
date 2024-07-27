<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDailyStatistic extends Model
{
    use HasFactory;

	protected $table = "game_daily_statistic";
	protected $fillable = ['new_players_bot', 'new_players_web', 'new_referrals', 'playing_from_bot', 'playing_from_web'];
	protected $guarded = ['id'];
	public $timestamps = true;
}

