<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', \App\Http\Controllers\PostSanctumTokenController::class);

Route::get('/first', \App\Http\Controllers\GetFirstController::class)->middleware('auth:sanctum');

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('/ok', '\App\Http\Controllers\userCheck@check');

Route::post('/list', '\App\Http\Controllers\userCheck@itemCheck');

Route::post('/login', '\App\Http\Controllers\userCheck@login');

Route::post('/register', '\App\Http\Controllers\userCheck@register');

Route::get('/list', '\App\Http\Controllers\ItemController@getList');

//cart routes
Route::post('/addcart', '\App\Http\Controllers\CartController@add');

Route::post('/cartList', '\App\Http\Controllers\CartController@cartList');

Route::put('/changeCart', '\App\Http\Controllers\CartController@changeCart');

Route::put('/deleteCart', '\App\Http\Controllers\CartController@deleteCart');

//chat routes
Route::post('/createChat', '\App\Http\Controllers\ChatController@createChat');

Route::post('/chatList', '\App\Http\Controllers\ChatController@chatList');

Route::post('/chatDetail', '\App\Http\Controllers\ChatController@chatDetail');

Route::post('/addChat', '\App\Http\Controllers\ChatController@addChat');

//add product
Route::post('/addProduct', '\App\Http\Controllers\ItemController@addProduct');

Route::post('/uploadImage', '\App\Http\Controllers\ItemController@uploadImage');

//add & change list
Route::post('/addList', '\App\Http\Controllers\ItemController@addList');

Route::put('/changeProduct', '\App\Http\Controllers\ItemController@changeProduct');

//sort関連api
Route::get('/search', '\App\Http\Controllers\ItemController@search');

Route::get('/ctg_search', '\App\Http\Controllers\ItemController@ctgSearch');

Route::post('/sort_search', '\App\Http\Controllers\ItemController@sortSearch');

//購入処理
Route::put('/buy', '\App\Http\Controllers\CartController@buy');

///管理処理
Route::post('/history', '\App\Http\Controllers\ManagementController@history');

Route::post('/getHistory', '\App\Http\Controllers\ManagementController@getHistory');

Route::post('/management', '\App\Http\Controllers\ManagementController@management');

Route::post('/getManagement', '\App\Http\Controllers\ManagementController@getManagement');
