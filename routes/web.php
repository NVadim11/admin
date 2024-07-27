<?php
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache cleared";
});

Route::get('/migrate-status', function () {
    Artisan::call('migrate:status');
    return dd(Artisan::output());
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', function () {
    return redirect('/admin');
});

Route::get('/log', function () {
    return file_get_contents('../storage/logs/laravel.log');
});
Route::get('/bot-reg', function () {
    return file_get_contents('../storage/logs/sql_bot_register.log');
});