<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\ReferralTransactions\Http\Controllers'], function()
{
	Route::resource('/referral_transactions', 'ReferralTransactionsController');
    Route::post('referral_transactions/modal-create', 'ReferralTransactionsController@modalCreate');
	Route::post('referral_transactions/ajax-update{id}', 'ReferralTransactionsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('referral_transactions/action-with-group', 'ReferralTransactionsController@actionWithGroup');
	Route::post('referral_transactions/data-table', 'ReferralTransactionsController@dataTable');
});
