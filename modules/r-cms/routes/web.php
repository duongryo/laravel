<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'rcms',
        'namespace' => 'RSolution\RCms\Http\Controllers\Web',
        'middleware' => ['web'],
        'as' => 'rcms.'
    ],
    function () {
        Route::resource('/login', 'AuthController', ['only' => ['index', 'store']]);

        Route::group(['middleware' => ['rcms']], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard.index');
            //
            
            Route::get('/manage-user/usage/{id}', 'ManageUserController@usage')->name('manage-user.usage');
            Route::resource('/manage-user', 'ManageUserController');
            //
            Route::get('/user-log/export', 'UserLogController@exportDataIndex')->name('user-log.export');
            Route::get('/user-log/export-detail/{id}', 'UserLogController@exportDataDetail')->name('user-log.export-detail');
            Route::resource('/user-log', 'UserLogController');
            //
            Route::get('/chart-log/export', 'ChartLogController@exportDataIndex')->name('chart-log.export');
            Route::resource('/chart-log', 'ChartLogController');
            //
            Route::post('/activation/destroy', 'ActivationController@destroy')->name('activation.destroy');
            Route::post('/activation/upgrade', 'ActivationController@upgrade')->name('activation.upgrade');
            Route::post('/activation/renew', 'ActivationController@renew')->name('activation.renew');
            Route::post('/activation/add-keyword-value', 'ActivationController@addKeywordValue')->name('activation.add_keyword_value');

            // crm
            Route::group(['prefix' => 'crm'], function () {
                Route::get('/', 'CrmController@index')->name('crm.index');
            });

            Route::resource('/payment-ticket', 'PaymentTicketController');
        });
        //Admin
        Route::group(['middleware' => ['rcms', 'rcms.admin']], function () {
            //
            Route::resource('/plans', 'PlanController');

            Route::resource('/modules', 'ModuleController');

            Route::resource('/limits', 'LimitController');

            Route::resource('/zoho-plans', 'ZohoPlanController');

            Route::resource('/stripe-plans', 'StripePlanController');
            //Config
            Route::group([
                'prefix' => 'config',
                'as' => 'config.',
                'namespace' => 'Config',
            ], function () {
                Route::resource('/sidebar', 'SidebarController');
                Route::resource('/free-trial', 'FreeTrialController');
                Route::resource('/subscription', 'SubscriptionController');
                Route::resource('/shareasale', 'ShareasaleController');
            });

            Route::get('/login-as-user', 'ManageUserController@loginAsUser')->name('login-as-user');
        });
    }
);
