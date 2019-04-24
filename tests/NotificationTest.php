<?php

namespace Hedeqiang\UMeng\Tests;

use PHPUnit\Framework\TestCase;
use Hedeqiang\UMeng\Android;

class NotificationTest extends TestCase
{
    protected $config = [
        'appKey' => '5b1df163f********',
        'appMasterSecret' => 'i7tzdarswt***********',
        'debug' => false,
    ];

    public function testsendAndroidCustomizedcast()
    {

        $andorid = new Android($this->config);

        $params = [
            "ticker" => "测试提示文字",
            "title" => "测试标题",
            "text" => "测试文字描述",
            "after_open" => "go_app",

        ];
        $extra = [
            'key1' => 'val1',
            'key2' => 'val2',
        ];
        $response = $andorid->sendAndroidBroadcast($params, $extra);
        $this->assertTrue(true);
    }

    public function testsendAndroidBroadcast()
    { }
}
