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

use Hedeqiang\UMeng\Push;

$config = [
    'deviceType' => 'Android',//Android、iOS、All
    'Android' => [
        'appKey' => '***********',
        'appMasterSecret' => '***********',
        'production_mode' => true,
    ],
    'iOS' => [
        'appKey' => '***********',
        'appMasterSecret' => '***********',
        'production_mode' => true,
];
```
## 消息发送

## 任务类消息状态查询

## 任务类消息取消

## 文件上传


## 参考
* [U-Push API 集成文档](https://developer.umeng.com/docs/66632/detail/68343)


## 工具
<a target="_blank" href="https://www.jetbrains.com/?from=UMeng-Push"><img src="https://upyun.laravelcode.cn/upload/JetBrains/jetbrains-training-partner.png" width="100"></img></a>

## License

MIT

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhedeqiang%2FUMeng-Push?ref=badge_large)
