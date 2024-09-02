<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\Notifications\Http\Controllers'], function()
{
	Route::resource('/notifications', 'NotificationsController');
    Route::post('notifications/modal-create', 'NotificationsController@modalCreate');
	Route::post('notifications/ajax-update{id}', 'NotificationsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('notifications/action-with-group', 'NotificationsController@actionWithGroup');
	Route::post('notifications/data-table', 'NotificationsController@dataTable');
});
