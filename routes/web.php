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
    // TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
    // SubscriptionPlanの実装確認のため仮実装する
    return view('select');
});

// TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
// SubscriptionPlanの実装確認のため仮実装する
Route::get('/select', function () {
    return view('select');
});
Route::post('/select', 'SubscriptionController@select');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/stripe', 'SubscriptionController@create');

Route::get('/credit', function () {
    return view('credit');
});