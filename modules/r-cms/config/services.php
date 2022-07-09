<?php

return [
    'telegram' => [
        'bot_token' => '945151095:AAHNux9jpUJ6iH0VlY-ZYyIVgrX8u05sUiM',
        'realtime_group' => env('RCMS_TELEGRAM_GROUP', '-310463162'), // Group realtime report
        'log_group' => env('RCMS_TELEGRAM_LOG', '-310463162'), // Group logs report
        'stripe_log_group' => env('RCMS_TELEGRAM_STRIPE_LOG', '-310463162'), // Group logs report,
        'daily_report_group' => env('RCMS_TELEGRAM_DAILY_REPORT', '-310463162'), // Group logs report
    ]
];
