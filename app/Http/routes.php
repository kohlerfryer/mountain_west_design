<?php


Route::get('/', function()
{
	return View::make('home');
});
Route::get('login', function()
{
	if(Auth::guest())
	return View::make('auth/login');
	else return View::make('add_stone', ['current_page' => 'add_stone' , 'user_name' => Auth::user()]);
});
Route::get('register', function()
{
	if(Auth::guest())
	return View::make('auth/register');
	else return View::make('add_stone', ['current_page' => 'add_stone' , 'user_name' => Auth::user()]);
});

//Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@logout');
Route::post('auth/register', 'Auth\AuthController@register');

Route::get('admin/{page_request}','AdminController@page_request');
Route::post('admin_panel/add_stone', 'AdminController@add_stone');
Route::get('admin_panel/populate_stone', 'AdminController@populate_stone');
Route::post('admin_panel/update_stone', 'AdminController@update_stone');
Route::get('admin_panel/get_stone', 'AdminController@get_stone');
Route::get('admin_panel/delete_stone', 'AdminController@delete_stone');

Route::get('kitchen_dreamer', function(){return View::make('kitchen_dreamer');});
