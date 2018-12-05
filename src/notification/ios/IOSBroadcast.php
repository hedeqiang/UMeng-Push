<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\notification\ios;

use Hedeqiang\UMeng\notification\IOSNotification;

class IOSBroadcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'broadcast';
    }
}
