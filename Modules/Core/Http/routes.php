<?php
Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Core\Http\Controllers'], function() {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

});

Route::group(['prefix' => getCurrentLocale()], function() {
    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'namespace' => 'Modules\Core\Http\Controllers'], function() {
        Route::get('/', 'IndexController@index')->name('admin.index');
        Route::post('store', 'IndexController@store')->name('admin.store');
        Route::post('/images/upload', 'ImagesController@upload');
        Route::post('/images/upload_file', 'ImagesController@uploadFile');
        Route::post('/images/upload_one', 'ImagesController@uploadOne');
        Route::post('/images/upload_one_by', 'ImagesController@uploadOneBy');
        Route::post('/images/upload_many', 'ImagesController@uploadMany');
        Route::post('/images/upload_many_custom', 'ImagesController@uploadManyCustom');
        Route::get('/images/files_list', 'ImagesController@files_list');
        Route::delete('/images/destroy', 'ImagesController@destroy');
        Route::post('/images/sort', 'ImagesController@sortImages');

        Route::post('/sort', 'SortController@index');
        Route::post('/index_sort', 'IndexSortController@index');

        Route::resource('/settings', 'SettingsController');

        Route::resource('/users', 'UsersController');
        Route::post('users/data-table', 'UsersController@dataTable');
        Route::resource('/groups', 'GroupsController');
        Route::post('groups/modal-create', 'GroupsController@modalCreate');
        Route::post('groups/ajax-update{id}', 'GroupsController@ajaxUpdate')->where('id', '([\d]+)?');
        Route::post('groups/action-with-group', 'GroupsController@actionWithGroup');
        Route::post('groups/data-table', 'GroupsController@dataTable');
        Route::resource('/modules', 'ModulesController');
        Route::resource('/feedback', 'FeedbackController');
    });
});