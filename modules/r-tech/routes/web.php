<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'rcms',
        'namespace' => 'RTech\Http\Controllers',
        'middleware' => ['web'],
        'as' => 'rcms.'
    ],
    function () {
      
        Route::group(['middleware' => ['rcms', 'web']], function () {
            
            Route::resource('post', 'PostController');
            Route::patch('/post/{id}/date', 'PostController@updateField');
            Route::patch('/post/{id}/update-fillable', 'PostController@updateFieldCustom');

            Route::resource('category', 'PostCategoryController');
            Route::patch('/category/{id}/update-fillable', 'PostCategoryController@updateField');

            Route::resource('system-config', 'SystemConfigController');

            Route::resource('team-members', 'TeamMembersController');
            Route::patch('/team-members/{id}/update-fillable', 'TeamMembersController@updateFieldCustom');

            Route::resource('product', 'ProductController');
            Route::patch('/product/{id}/date', 'ProductController@updateField');
            Route::patch('/product/{id}/update-fillable', 'ProductController@updateFieldCustom');

        });
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['rcms']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    }
);