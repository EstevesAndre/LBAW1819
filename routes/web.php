<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('index');
});

// Cards
Route::get('cards', 'PostController@list');
Route::get('cards/{id}', 'PostController@show');

// API
Route::put('api/cards', 'PostController@create');
Route::delete('api/cards/{card_id}', 'PostController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');
//---------------------------------------------------------//

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('index', 'Auth\LoginController@showIndexPage');

// Public Pages
Route::get('about', 'PublicController@showAboutPage');
Route::get('faqs', 'PublicController@showFaqsPage');
Route::get('404', 'PublicController@show404Page');

// Authenticated Pages
Route::get('home', 'PostController@showPage');
Route::get('createClan', 'ClanController@showCreateClanPage');

// Posts
Route::get('posts', 'PostController@list');
Route::get('post/{id}', 'PostController@show');

// Users
Route::get('user/{id}', 'UserController@show');
