<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\Facades;

use Illuminate\Support\Facades\Facade;

class Push extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'push.push';
    }

    /**
     * Return the facade accessor.
     * @return \Hedeqiang\UMeng\Android
     */
    public static function android()
    {
        return app('push.android');
    }

    /**
     * Return the facade accessor.
     * @return \Hedeqiang\UMeng\IOS
     */
    public static function ios()
    {
        return app('push.ios');
    }

}