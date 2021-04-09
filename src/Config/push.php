<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'Android' => [
        'appKey'          => env('ANDROID_PUSH_APP_KEY'),
        'appMasterSecret' => env('ANDROID_PUSH_APP_MASTER_SECRET'),
        'production_mode' => env('ANDROID_PUSH_PRODUCTION_MODE'),
    ],
    'iOS' => [
        'appKey'          => env('IOS_PUSH_APP_KEY'),
        'appMasterSecret' => env('IOS_PUSH_APP_MASTER_SECRET'),
        'production_mode' => env('IOS_PUSH_PRODUCTION_MODE'),
    ],
];
