<?php
Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('user_actions', 'Admin\UserActionsController');
    Route::resource('links', 'Admin\LinksController');
    Route::get('links/{id}/crawler', 'Admin\LinksController@crawler')->name('links.crawler');
    Route::get('links_import', ['uses' => 'Admin\LinksController@getViewImport', 'as' => 'links.view.import']);
    Route::post('links_import', ['uses' => 'Admin\LinksController@parseImport', 'as' => 'links.parse.import']);
    Route::post('links_import_process', ['uses' => 'Admin\LinksController@import', 'as' => 'links.import.process']);
    Route::post('links_mass_destroy', ['uses' => 'Admin\LinksController@massDestroy', 'as' => 'links.mass_destroy']);
    Route::post('links_restore/{id}', ['uses' => 'Admin\LinksController@restore', 'as' => 'links.restore']);
    Route::delete('links_perma_del/{id}', ['uses' => 'Admin\LinksController@perma_del', 'as' => 'links.perma_del']);
    Route::resource('extract_managers', 'Admin\ExtractResultController');
    Route::post('extract_managers_mass_destroy', ['uses' => 'Admin\ExtractResultController@massDestroy', 'as' => 'extract_managers.mass_destroy']);
    Route::post('extract_managers_restore/{id}', ['uses' => 'Admin\ExtractResultController@restore', 'as' => 'extract_managers.restore']);
    Route::delete('extract_managers_perma_del/{id}', ['uses' => 'Admin\ExtractResultController@perma_del', 'as' => 'extract_managers.perma_del']);
    Route::post('/spatie/media/upload', 'Admin\SpatieMediaController@create')->name('media.upload');
    Route::post('/spatie/media/remove', 'Admin\SpatieMediaController@destroy')->name('media.remove');
});
