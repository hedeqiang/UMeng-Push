<h1 align="center"> umeng </h1>

<p align="center"> 友盟推送SDK</p>

![StyleCI build status](https://github.styleci.io/repos/160544563/shield) 
[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
[![HitCount](http://hits.dwyl.io/hedeqiang/umeng.svg)](http://hits.dwyl.io/hedeqiang/umeng)
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

// Android 
$config = [
    'appKey' => '5b1df1**************',
    'appMasterSecret' => 'i7tzdarsw************',
    'debug' => false,
];
// IOS 
$ios_config = [
    'appKey' => '5b1df0d1************',
    'appMasterSecret' => 'fa9ry9kd*********',
    'debug' => false,
]

$android = new Android($config));

$ios = new IOS($ios_config);
```
## Android
### customizedcast消息发送示例
```
$params = [
    'alias_type' => 'APP',
    'alias' => 1,
    "ticker" => "测试提示文字",
    "title" => "测试标题",
    "text" => "测试文字描述",
    "after_open" => "go_app",
    "description" => "测试广播通知-Android",
];

$response = $android->sendAndroidCustomizedcast($params);
```
### broadcast消息发送示例
```
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

$response = $android->sendAndroidBroadcast($params, $extra);
```

### unicast消息发送示例
```
$params = [
    "device_tokens" => "测试提示文字",
    "display_type" => "notification", // message：消息 notification：通知
    //"custom" => '自定义custom',
    //以下内容为 notification  必填项 
    "ticker" => "测试提示文字",
    "title" => "测试标题",
    "text" => "测试文字描述",
    "after_open" => "go_app",

];
//可选项
$extra = [
    'key1' => 'val1',
    'key2' => 'val2',
];

$response = $android->sendAndroidUnicast($params, $extra);
```

### filecast消息发送示例
```
$params = [
    "ticker" => "测试提示文字",
    "title" => "测试标题",
    "text" => "测试文字描述",
    "after_open" => "go_app",
];
//
$content = "aa" . "\n" . "bb";

$response = $android->sendAndroidFilecast($params, $content);
```

### groupcast消息发送示例
```
$params = [
    "ticker" => "测试提示文字",
    "title" => "测试标题",
    "text" => "测试文字描述",
    "after_open" => "go_app",
];
//

$filter = [
    'where' => [
        'and' => [
            'tag' => 'test',
            'tag1' => 'test2',
        ],
    ],
];

$response = $android->sendAndroidGroupcast($filter, $params);
```

### sendAndroidCustomizedcastFileId 消息示例
```
 $params = [
    "ticker" => "测试提示文字",
    "title" => "测试标题",
    "text" => "测试文字描述",
    "after_open" => "go_app",
    'alias_type' => 'APP',
];
$content = "aa" . "\n" . "bb";

$response = $android->sendAndroidCustomizedcastFileId($params, $content);
```



## IOS
### broadcast消息发送示例 
```
$params = [
    'alert' => [
        'title' => 'title',
        'body' => 'body',
    ],  //字符串或者JSON
    "description" => "测试广播通知-iOS"
];
$customized = [
    'key' => 'jey',
]; //可选
$response = $ios->sendIOSBroadcast($params, $customized);
```

###  unicast消息发送示例 
```
$params = [
    'device_tokens' => 'token',
    'alert' => [
        'title' => 'title',
        'body' => 'body',
    ],  //字符串或者JSON
    "description" => "测试单播消息-iOS"
];
$customized = [
    'key' => 'jey',
]; //可选
$response = $ios->sendIOSUnicast($params, $customized);
```

###  filecast消息发送示例
```
$params = [
    'device_tokens' => 'token',
    'alert' => [
        'title' => 'title',
        'body' => 'body',
    ],  //字符串或者JSON
    "description" => "测试filecast文件通知-iOS"
];
$content = "aa" . "\n" . "bb";

$response = $ios->sendIOSFilecast($params, $content);
```

### groupcast消息发送示例
```
$params = [
    'alert' => [
        'title' => 'title',
        'body' => 'body',
    ],  //字符串或者JSON
    "description" => "测试组播通知-iOS"
];
$filter = [
    'where' => [
        'and' => [
            'tag' => 'test',
            'tag1' => 'test2',
        ],
    ],
];

$response = $ios->sendIOSGroupcast($filter, $params);
```

### customizedcast消息发送示例
```
$params = [
    'alert' => [
        'title' => 'title',
        'body' => 'body',
    ],  //字符串或者JSON
    'alias_type' => 'APP',
    'alias' => 1,
    "description" => "测试alias通知-iOS"
];


$response = $ios->sendIOSCustomizedcast($params);
```
## 参考
* [U-Push API 集成文档](https://developer.umeng.com/docs/66632/detail/68343)

## License

MIT