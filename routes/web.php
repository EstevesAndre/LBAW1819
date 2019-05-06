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

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('index', 'Auth\LoginController@showIndexPage');

// API
Route::delete('/api/like/{id}', 'LikeController@delete');
Route::put('/api/like/{id}', 'LikeController@create');
Route::put('/api/post', 'PostController@create');
Route::delete('/api/post/{id}', 'PostController@delete');
Route::post('/api/createClan', 'ClanController@create');

// Public Pages
Route::get('about', 'PublicController@showAboutPage');
Route::get('faqs', 'PublicController@showFaqsPage');
Route::get('404', 'PublicController@show404Page');

// Authenticated Pages
Route::get('home', 'PrivateController@show');
Route::get('createClanPage', 'ClanController@showCreateClanPage');

// Posts
Route::get('posts', 'PostController@list');
Route::get('post/{id}', 'PostController@show');

// Users
Route::get('user/{username}', 'UserController@show');

// Clan
Route::get('clan', 'ClanController@show');
Route::get('clan/{id}', 'ClanController@show');
