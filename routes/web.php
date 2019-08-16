<?php

Route::get('/', 'HomeController@all');

Route::post('/select', 'SubscriptionController@select');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/stripe', 'SubscriptionController@create');

Route::post('/unsubscribe', 'SubscriptionController@unsubscribe');

Route::get('/credit', function () {
    return view('credit');
});
