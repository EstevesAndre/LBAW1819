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
Route::post('createChar', 'Auth\RegisterController@createCharacter');

// API
Route::delete('/api/like/{id}', 'LikeController@delete');
Route::put('/api/like/{id}', 'LikeController@create');
Route::put('/api/post', 'PostController@create');
Route::delete('/api/post/{id}', 'PostController@delete');
Route::post('/api/createClan', 'ClanController@create');
Route::post('/api/notifications', 'PrivateController@getNotifications');
Route::put('/api/comment/{id}', 'CommentController@create');
Route::delete('/api/comment/{id}', 'CommentController@delete');
Route::put('/api/chat/{id}', 'MessageController@create');
Route::post('/api/update_chat/{id}', 'UserController@getFriendsMessages');
Route::post('/api/update_clan/{id}', 'ClanController@update');
Route::post('/api/share/{id}', 'PostController@share');
Route::put('/api/banMember/{id}', 'ClanController@banMember');
Route::put('/api/unbanMember/{user_id}+{clan_id}', 'ClanController@unbanMember');
Route::post('/api/inviteUsers/{clan_id}', 'ClanController@inviteUsers');
Route::get('/api/deleteClan/{clan_id}', 'ClanController@delete');
Route::get('/api/seeMoreHome/{cur_page}', 'PrivateController@seeMoreHome');

Route::put('/api/banUser/{id}', 'BlockedController@createBanUser');
Route::put('/api/banClan/{id}', 'BlockedController@createBanClan');
Route::put('/api/addPermissions/{id}', 'UserController@addPermissions');
Route::delete('/api/unbanUser/{id}', 'BlockedController@deletebanUser');
Route::delete('/api/unbanClan/{id}', 'BlockedController@deletebanClan');
Route::delete('/api/removePermissions/{id}', 'UserController@removePermissions');

Route::delete('/api/removeFriend/{friend}', 'UserController@removeFriend');
Route::put('/api/sendFriend/{friend}', 'UserController@sendFriendRequest');
Route::delete('/api/cancelFriend/{friend}', 'UserController@cancelFriendRequest');
Route::put('/api/answerFriend/{friend}+{accepted}', 'UserController@answerFriendRequest');

Route::get('/api/leaveClan/{user}', 'ClanController@leaveClan');

// Public Pages
Route::get('about', 'PublicController@showAboutPage');
Route::get('faqs', 'PublicController@showFaqsPage');
Route::get('404', 'PublicController@show404Page');

// Authenticated Pages
Route::get('home', 'PrivateController@showHome');
Route::get('leaderboard', 'PrivateController@showLeaderboard');
Route::get('chat', 'PrivateController@showChat');
Route::get('friendRequests', 'RequestController@show');
Route::get('createCharacter', 'PrivateController@showCreateCharacter');

// Searchs
Route::post('/api/getLeaderboardGlobalSearch', 'PrivateController@getLeaderboardGlobalSearch');
Route::post('/api/getLeaderboardClanSearch', 'PrivateController@getLeaderboardClanSearch');
Route::post('/api/getLeaderboardFriendsSearch', 'PrivateController@getLeaderboardFriendsSearch');
Route::post('/api/getFriendsListSearch/{id}', 'UserController@getFriendsListSearch');
Route::post('/api/getClanSearch/{id}', 'ClanController@getClanSearch');
Route::post('/api/getActiveUsersSearch', 'UserController@getActiveUsersSearch');
Route::post('/api/getBannedUsersSearch', 'UserController@getBannedUsersSearch');
Route::post('/api/getActiveClansSearch', 'ClanController@getActiveClansSearch');
Route::post('/api/getBannedClansSearch', 'ClanController@getBannedClansSearch');
Route::post('/api/getActiveAdminsSearch', 'AdminController@getActiveAdminsSearch');
Route::post('/api/getPotentialAdminsSearch', 'AdminController@getPotentialAdminsSearch');
Route::post('/api/getActiveClanUsersSearch/{id}', 'ClanController@getActiveClanUsersSearch');
Route::post('/api/getBannedClanUsersSearch/{id}', 'ClanController@getBannedClanUsersSearch');

// Posts
Route::get('posts', 'PostController@list');
Route::get('post/{id}', 'PostController@show');
Route::get('share/{post_id}_{user_id}', 'ShareController@show');

// Users
Route::get('user/{username}', 'UserController@show');

// Clan
Route::get('createClanPage', 'ClanController@showCreateClanPage');
Route::get('clan', 'ClanController@show');
Route::get('clanSettings', 'ClanController@showClanSettings');

// Admin
Route::get('administrator', 'AdminController@show');
