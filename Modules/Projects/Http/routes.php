<?php

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Modules\Projects\Http\Controllers'], function()
{
    Route::resource('/projects/{project}/projects-tasks', 'ProjectsTasksController');
    Route::post('projects/{project}/projects-tasks/modal-create', 'ProjectsTasksController@modalCreate');
    Route::post('projects/{project}/projects-tasks/modal-export', 'ProjectsTasksController@modalExport');
    Route::post('projects/{project}/projects-tasks/ajax-update{id}', 'ProjectsTasksController@ajaxUpdate')->where('id', '([\d]+)?');
    Route::post('projects/{project}/projects-tasks/action-with-group', 'ProjectsTasksController@actionWithGroup');
    Route::post('projects/{project}/projects-tasks/data-table', 'ProjectsTasksController@dataTable');

    Route::resource('/projects/{project}/projects-images', 'ProjectsImagesController');
    Route::post('projects/{project}/projects-images/modal-create', 'ProjectsImagesController@modalCreate');
    Route::post('projects/{project}/projects-images/modal-export', 'ProjectsImagesController@modalExport');
    Route::post('projects/{project}/projects-images/ajax-update{id}', 'ProjectsImagesController@ajaxUpdate')->where('id', '([\d]+)?');
    Route::post('projects/{project}/projects-images/action-with-group', 'ProjectsImagesController@actionWithGroup');
    Route::post('projects/{project}/projects-images/data-table', 'ProjectsImagesController@dataTable');

    Route::resource('/projects', 'ProjectsController');
    Route::post('projects/modal-create', 'ProjectsController@modalCreate');
    Route::post('projects/modal-export', 'ProjectsController@modalExport');
	Route::post('projects/ajax-update{id}', 'ProjectsController@ajaxUpdate')->where('id', '([\d]+)?');
	Route::post('projects/action-with-group', 'ProjectsController@actionWithGroup');
	Route::post('projects/data-table', 'ProjectsController@dataTable');
});
