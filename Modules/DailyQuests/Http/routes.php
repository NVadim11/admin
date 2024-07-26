<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\DailyQuests\Http\Controllers'], function()
{
	Route::resource('/daily_quests', 'DailyQuestsController');
    Route::post('daily_quests/modal-create', 'DailyQuestsController@modalCreate');
	Route::post('daily_quests/ajax-update{id}', 'DailyQuestsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('daily_quests/action-with-group', 'DailyQuestsController@actionWithGroup');
	Route::post('daily_quests/data-table', 'DailyQuestsController@dataTable');
});
