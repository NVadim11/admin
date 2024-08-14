<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\PartnersQuests\Http\Controllers'], function()
{
	Route::resource('/partners_quests', 'PartnersQuestsController');
    Route::post('partners_quests/modal-create', 'PartnersQuestsController@modalCreate');
	Route::post('partners_quests/ajax-update{id}', 'PartnersQuestsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('partners_quests/action-with-group', 'PartnersQuestsController@actionWithGroup');
	Route::post('partners_quests/data-table', 'PartnersQuestsController@dataTable');
});
