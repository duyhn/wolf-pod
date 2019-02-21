<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('links', 'LinksController', ['except' => ['create', 'edit']]);

        Route::resource('extract_managers', 'ExtractManagersController', ['except' => ['create', 'edit']]);

});
