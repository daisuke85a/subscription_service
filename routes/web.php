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

<<<<<<< HEAD
// Route::get('/', function () {
//     // TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
//     // SubscriptionPlanの実装確認のため仮実装する
//     return view('select');
// });
//TODO(だん)：ルートパースをコントローラーを通してから判断したいので書き換えました
Route::get('/', 'HomeController@all');

// TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
// SubscriptionPlanの実装確認のため仮実装する
// Route::get('/select', function () {
//     return view('select');
// });
=======
// TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
// SubscriptionPlanの実装確認のため仮実装する
Route::get('/', function () {
    return view('select');
});

// TODO: 本来は'/'にアクセスして、HomeController@indexにて表示画面を判定する
// SubscriptionPlanの実装確認のため仮実装する
Route::get('/normal', function () {
    return view('normal');
});
>>>>>>> 154f994f514f21238aaa216f43b223548e1e776b

// 管理者ユーザーがログインしたら、呼ばれる(管理画面を表示)
Route::get('/admin', 'HomeController@show_admin_screen');

//サブスクリプションプランの選択がされたら呼ばれる
Route::post('/select', 'SubscriptionController@select');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Stripeのクレジットカード情報の検証が完了したら呼ばれる
Route::post('/stripe', 'SubscriptionController@create');

// Stripeのサブスクプリションを退会する時に呼ばれる
Route::post('/unsubscribe', 'SubscriptionController@unsubscribe');

// クレジットカード情報の入力画面を表示する
Route::get('/credit', function () {
    return view('credit');
});