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

interface PushInterface
{
    public function send(array $params): array;

    public function status(array $params): array;

    public function cancel(array $params): array;

    public function upload(array $params): array;
}
