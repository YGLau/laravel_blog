<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Home\IndexController@index');
Route::get('/list/{nav_id}', 'Home\IndexController@cate');
Route::get('/a/{art_id}', 'Home\IndexController@article');

Route::get('admin/index', 'Admin\IndexController@index');
Route::get('admin/info', 'Admin\IndexController@info');
Route::any('admin/login', 'Admin\AdminController@login');
Route::get('admin/code', 'Admin\AdminController@code');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::any('index', 'IndexController@index')->middleware('admin.login');
    Route::get('info', 'IndexController@info')->middleware('admin.login');
    Route::get('quit', 'AdminController@quit')->middleware('admin.login');
    Route::any('pass', 'IndexController@pass')->middleware('admin.login');
    Route::resource('category', 'CategoryController');
    Route::post('cate/changeorder', 'CategoryController@changeOrder')->middleware('admin.login');
    Route::resource('article', 'ArticleController');
    Route::any('upload', 'BaseController@upload')->middleware('admin.login');

    Route::resource('links', 'LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder')->middleware('admin.login');

    Route::resource('navs', 'NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder')->middleware('admin.login');

    Route::get('conf/putfile', 'ConfigController@putFile')->middleware('admin.login');
    Route::resource('conf', 'ConfigController');
    Route::post('conf/changeorder', 'ConfigController@changeOrder')->middleware('admin.login');
    Route::post('conf/changecontent', 'ConfigController@changeContent')->middleware('admin.login');

});



