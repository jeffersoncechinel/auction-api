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

/*Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api'],
], function () {
    Route::resource('items', 'ItemController', ['except' => ['create', 'edit']]);
    Route::resource('bids', 'BidController', ['except' => ['create', 'edit']]);
    Route::resource('wallet', 'UserWalletController', ['except' => ['create', 'edit']]);
    Route::resource('auto-bidding', 'UserAutoBiddingController', ['except' => ['create', 'edit']]);
});

Route::namespace('Api')->group(function () {
    Route::post('auth', 'AuthController@index');
});



