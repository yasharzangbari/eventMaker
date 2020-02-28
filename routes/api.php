<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register' , 'User\UserController@store');
Route::post('/login' , 'User\UserController@create');


Route::middleware(['auth:api'])->group(function () {

    Route::resource('parties' , 'Party\PartyController' , ['only' => [ 'store']]);
    Route::resource('/invites' , 'Invite\InvitedUserController' , ['only' => ['index', 'store' , 'update']]);
    Route::post('/users/avatar' , 'User\UserController@uploadAvatar');
    Route::post('/logout' , 'User\UserController@logout');
    Route::get('/user/invited' , 'Invite\InvitedUserController@partiesInvited');

});