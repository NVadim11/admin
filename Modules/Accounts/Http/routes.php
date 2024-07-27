<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\Accounts\Http\Controllers'], function()
{

    Route::resource('/accounts/{event}/accounts-rooms/{room}/accounts-rooms-images', 'AccountRoomsImagesController');
    Route::post('accounts/{event}/accounts-rooms/{room}/accounts-rooms-images/modal-create', 'AccountRoomsImagesController@modalCreate');
    Route::post('accounts/{event}/accounts-rooms/{room}/accounts-rooms-images/ajax-update{id}', 'AccountRoomsImagesController@ajaxUpdate')->where('id', '([\d]+)?');
    Route::post('accounts/{event}/accounts-rooms/{room}/accounts-rooms-images/action-with-group', 'AccountRoomsImagesController@actionWithGroup');
    Route::post('accounts/{event}/accounts-rooms/{room}/accounts-rooms-images/data-table', 'AccountRoomsImagesController@dataTable');

    Route::resource('/accounts/{event}/accounts-rooms', 'AccountRoomsController');
    Route::post('accounts/{event}/accounts-rooms/modal-create', 'AccountRoomsController@modalCreate');
    Route::post('accounts/{event}/accounts-rooms/ajax-update{id}', 'AccountRoomsController@ajaxUpdate')->where('id', '([\d]+)?');
    Route::post('accounts/{event}/accounts-rooms/action-with-group', 'AccountRoomsController@actionWithGroup');
    Route::post('accounts/{event}/accounts-rooms/data-table', 'AccountRoomsController@dataTable');

	Route::resource('/accounts/{event}/accounts-graves-items', 'AccountGravesItemsController');
    Route::post('accounts/{event}/accounts-graves-items/modal-create', 'AccountGravesItemsController@modalCreate');
	Route::post('accounts/{event}/accounts-graves-items/ajax-update{id}', 'AccountGravesItemsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('accounts/{event}/accounts-graves-items/action-with-group', 'AccountGravesItemsController@actionWithGroup');
	Route::post('accounts/{event}/accounts-graves-items/data-table', 'AccountGravesItemsController@dataTable');

    Route::resource('/accounts/{event}/accounts-controlled-graves-items', 'AccountControlledGravesItemsController');
    Route::post('accounts/{event}/accounts-controlled-graves-items/modal-create', 'AccountControlledGravesItemsController@modalCreate');
    Route::post('accounts/{event}/accounts-controlled-graves-items/ajax-update{id}', 'AccountControlledGravesItemsController@ajaxUpdate')->where('id', '([\d]+)?');
    Route::post('accounts/{event}/accounts-controlled-graves-items/action-with-group', 'AccountControlledGravesItemsController@actionWithGroup');
    Route::post('accounts/{event}/accounts-controlled-graves-items/data-table', 'AccountControlledGravesItemsController@dataTable');

	Route::resource('/accounts', 'AccountsController');
    Route::post('accounts/modal-create', 'AccountsController@modalCreate');
	Route::post('accounts/ajax-update{id}', 'AccountsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('accounts/action-with-group', 'AccountsController@actionWithGroup');
	Route::post('accounts/data-table', 'AccountsController@dataTable');
});
