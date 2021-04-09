<h1 align="center"> umeng </h1>

<p align="center"> 友盟推送SDK</p>

![StyleCI build status](https://github.styleci.io/repos/160544563/shield) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push?ref=badge_shield)
[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
[![HitCount](http://hits.dwyl.io/hedeqiang/umeng.svg)](http://hits.dwyl.io/hedeqiang/umeng)

> 如需极光推送 请前往 [极光推送](https://github.com/hedeqiang/JPush)

## Installing

```shell
$ composer require hedeqiang/umeng -vvv
```
## 配置
在使用本扩展之前，你需要去 [友盟+](https://message.umeng.com) 注册账号，然后创建应用，获取应用的 Key 和秘钥。

## 使用

```php
require __DIR__ .'/vendor/autoload.php';

use Hedeqiang\UMeng\Android;
use Hedeqiang\UMeng\IOS;

$config = [
    'Android' => [
        'appKey' => '***********',
        'appMasterSecret' => '***********',
        'production_mode' => true,
    ],
    'iOS' => [
        'appKey' => '***********',
        'appMasterSecret' => '***********',
        'production_mode' => true,
    ]
];

$android = new Android($config);
$ios = new IOS($config);
```

> params 接受数组，安装官方文档示例，转化为数组格式即可 `appkey`` 和 `timestamp` 可传可不传。以下为示例代码。可供参考


## 消息发送
### unicast 消息发送示例
```php
// Android
$params = [
    'type' => 'unicast',
    'production_mode' => 'false',
    'device_tokens' => 'xx(Android为44位)',
    'payload' => [
        'display_type' => 'message',
        'body' => [
            'custom' => '自定义custom',
        ],
    ],
    'policy' => [
        'expire_time' => '2013-10-30 12:00:00',
    ],
    'description' => '测试单播消息-Android',
];

print_r($android->send($params));

// iOS
$params = [
    'type' => 'unicast',
    'production_mode' => 'false',
    'device_tokens' => 'xx(iOS为64位)',
    'payload' => [
        'aps' => [
            'alert' => [
                'title' => 'title',
                'subtitle' => 'subtitle',
                'body' => 'body',
            ]
        ],
    ],
    'policy' => [
        'expire_time' => '2021-04-09 10:23:24',
    ],
    'description' => '测试单播消息-iOS',
];
print_r($push->send($params));
```



## 任务类消息状态查询
```php
$params = [
    'task_id' => 'xx'
];
print_r($push->status($params));
```
## 任务类消息取消
```php
$params = [
    'task_id' => 'xx'
];
print_r($push->cancel($params));
```
## 文件上传
```php
$params = [
    'content' => 'xx'
];
print_r($push->upload($params));
```

## 参考
* [U-Push API 集成文档](https://developer.umeng.com/docs/66632/detail/68343)


## 工具
<a target="_blank" href="https://www.jetbrains.com/?from=UMeng-Push"><img src="https://upyun.laravelcode.cn/upload/JetBrains/jetbrains-training-partner.png" width="100"></img></a>

## License

MIT

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push?ref=badge_large)
