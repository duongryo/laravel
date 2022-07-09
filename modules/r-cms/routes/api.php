<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'api/services/r-cms',
        'namespace' => 'RSolution\RCms\Http\Controllers\Api',
        'middleware' => ['web', 'services'],
        'as' => 'rcms.api.'
    ],
    function () {
        //Logs
        Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
            Route::get('/get', 'UserLogController@getLogs');
            Route::post('/set', 'UserLogController@setLog');
        });

        //Profile
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/get', 'UserContoller@getProfile');
            Route::post('/update', 'UserContoller@updateProfile');
            Route::post('/update-password', 'UserContoller@updatePass');
        });

        //Usage
        Route::group(['prefix' => 'usage', 'as' => 'usage.'], function () {
            Route::post('/get', 'LimitController@getUsage');
            Route::get('/', 'LimitController@getAllUsage');
        });

        //Affiliate
        Route::group(['prefix' => 'affiliate', 'as' => 'affiliate.'], function () {
            Route::resource('transaction', 'AffiliateTransactionController');
            Route::get('info', 'AffiliateTransactionController@info');
        });

        //Payment
        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::post('/submit', 'PaymentController@submit');
            Route::get('/info', 'PaymentController@info');
            Route::get('/plans', 'PaymentController@getPlans');
            Route::post('/ticket/create', 'PaymentController@createTicket');
        });

        //Subscription
        Route::group(['prefix' => 'subscription', 'as' => 'subscription.'], function () {
            Route::get('/', 'SubscriptionController@index');
            Route::get('/create', 'SubscriptionController@create');
            Route::get('/callback', 'SubscriptionController@callback')->name('callback');
            Route::get('/billing-portal/create', 'SubscriptionController@createBillingPortal');
            Route::get('/pricing', 'SubscriptionController@getPricing');
            Route::post('/schedule-cancel', 'SubscriptionController@scheduleCancel');
        });

        //Transactions
        Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
            Route::get('/get-value', 'TransactionController@getValueTransaction');
            Route::get('/get-addon', 'TransactionController@getAddonTransaction');
            Route::resource('/', 'TransactionController');
        });

        Route::resource('/invoices', 'InvoiceController');
    }
);

Route::get(
    '/redirect',
    'RSolution\RCms\Http\Controllers\Api\AffiliateTransactionController@redirect'
)->middleware('web');


Route::post('api/services/r-cms/subscription/webhook', 'RSolution\RCms\Http\Controllers\Api\SubscriptionController@webhook');
