<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng;

class PushServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/push.php' => config_path('push.php'),
        ], 'push');
    }

    public function register()
    {
        $this->app->singleton(Android::class, function () {
            return new Android(config('push'));
        });
        $this->app->singleton(IOS::class, function () {
            return new IOS(config('push'));
        });

        $this->app->alias(Android::class, 'push.android');
        $this->app->alias(IOS::class, 'push.ios');
    }

    public function provides(): array
    {
        return ['push.android', 'push.ios'];
    }
}
