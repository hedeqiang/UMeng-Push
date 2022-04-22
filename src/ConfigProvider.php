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

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                IOS::class => static function (ContainerInterface $container) {
                    return new IOS($container->get(ConfigInterface::class)->get('umeng_push', []));
                },
                Android::class => static function (ContainerInterface $container) {
                    return new Android($container->get(ConfigInterface::class)->get('umeng_push', []));
                },
            ],
            'publish' => [
                [
                    'id'          => 'config',
                    'description' => 'The config for amqp.',
                    'source'      => __DIR__.'/Config/push.php',
                    'destination' => BASE_PATH.'/config/autoload/umeng_push.php',
                ],
            ],
        ];
    }
}
