<h1 align="center"> umeng </h1>

<p align="center"> 友盟推送SDK</p>

![StyleCI build status](https://github.styleci.io/repos/160544563/shield) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push?ref=badge_shield)
[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
[![HitCount](http://hits.dwyl.io/hedeqiang/umeng.svg)](http://hits.dwyl.io/hedeqiang/umeng)
[![PHPUnit](https://github.com/hedeqiang/UMeng-Push/actions/workflows/test.yml/badge.svg)](https://github.com/hedeqiang/UMeng-Push/actions/workflows/test.yml)

> 如需极光推送 请前往 [极光推送](https://github.com/hedeqiang/JPush)


> v2.x 推翻重写之前的官方 demo。用法更简单 如需v1.x 请查看 master 分支 

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

> params 接受数组，安装官方文档示例，转化为数组格式即可 `appkey` 和 `timestamp` 可传可不传。以下为示例代码。可供参考


## 消息发送
### unicast 消息发送示例
```php
// Android
$params = [
    'type' => 'unicast',
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

## 在 Hyperf 中使用

### 发布配置文件

```shell
php bin/hyperf.php vendor:publish hedeqiang/umeng
```

### 发送

```php
<?php

use Hedeqiang\UMeng\IOS;
use Hyperf\Utils\ApplicationContext;

ApplicationContext::getContainer()->get(IOS::class)->send([]);
```

## 在 Laravel 中使用

### 发布配置文件

```php
php artisan vendor:publish --tag=push
or 
php artisan vendor:publish --provider="Hedeqiang\UMeng\PushServiceProvider"
```

### 编写配置文件

```php
ANDROID_PUSH_APP_KEY=
ANDROID_PUSH_APP_MASTER_SECRET=
ANDROID_PUSH_PRODUCTION_MODE=

IOS_PUSH_APP_KEY=
IOS_PUSH_APP_MASTER_SECRET=
IOS_PUSH_PRODUCTION_MODE=
```

### 使用

#### 服务名访问
```php
public function index()
{
    return app('push.android')->send([]);
    return app('push.android')->status([]);
    return app('push.android')->cancel([]);
    return app('push.android')->upload([]);
    
    return app('push.ios')->send([]);
}
```

#### Facades 门面使用(可以提示)
```php
use Hedeqiang\UMeng\Facades\Push;

public function index()
{
    Push::android()->send([]);
    Push::android()->status([]);
    Push::android()->cancel([]);
    Push::android()->upload([]);
    
    Push::ios()->send([]);
}
```

## 参考
* [U-Push API 集成文档](https://developer.umeng.com/docs/66632/detail/68343)


## 工具
<a target="_blank" href="https://www.jetbrains.com/?from=UMeng-Push"><img src="https://upyun.laravelcode.cn/upload/JetBrains/jetbrains-training-partner.png" width="100"></img></a>

## License

MIT

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push?ref=badge_large)
