<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'RSolution\RCms\Http\Controllers',
        'middleware' => ['web'],
        'as' => 'rcms.'
    ],
    function () {
        Route::get('/auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('socialite.redirect');
        Route::get('/auth/{provide}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('socialite.callback');
        Route::get('/change-language/{language}', 'PublicController@changeLanguage')->name('language.change');

        Route::get('/block', 'PublicController@block')->name('block');
        Route::get('/thankyou', 'PublicController@thankyou')->name('thankyou');
        Route::get('/404', 'PublicController@error')->name('404');
        Route::get('/maintenance', 'PublicController@maintenance')->name('maintenance');

        //
    }
);
