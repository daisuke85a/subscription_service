<?php

Route::get('/', 'HomeController@all');

Auth::routes();

Route::post('/select', 'SubscriptionController@select');
Route::post('/stripe', 'SubscriptionController@create');
Route::post('/unsubscribe', 'SubscriptionController@unsubscribe');

Route::get('/credit', 'SubscriptionController@inputCredit');