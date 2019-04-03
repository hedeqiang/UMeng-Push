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

use Hedeqiang\UMeng\notification\android\AndroidBroadcast;
use Hedeqiang\UMeng\notification\android\AndroidCustomizedcast;
use Hedeqiang\UMeng\notification\android\AndroidFilecast;
use Hedeqiang\UMeng\notification\android\AndroidGroupcast;
use Hedeqiang\UMeng\notification\android\AndroidUnicast;
use Hedeqiang\UMeng\notification\ios\IOSBroadcast;
use Hedeqiang\UMeng\notification\ios\IOSCustomizedcast;
use Hedeqiang\UMeng\notification\ios\IOSFilecast;
use Hedeqiang\UMeng\notification\ios\IOSGroupcast;
use Hedeqiang\UMeng\notification\ios\IOSUnicast;

/**
 * Class Android
 * @package Hedeqiang\UMeng
 */
class Android
{
    protected $appkey = null;

    protected $appMasterSecret = null;

    protected $timestamp = null;

    protected $validation_token = null;

    protected $production_mode = false;

    public function __construct($key, $secret, $production_mode)
    {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
        $this->production_mode = $production_mode;
    }

    public function sendAndroidBroadcast($ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue('appkey', $this->appkey);
            $brocast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $brocast->setPredefinedKeyValue('ticker', $ticker);
            $brocast->setPredefinedKeyValue('title', $title);
            $brocast->setPredefinedKeyValue('text', $text);
            $brocast->setPredefinedKeyValue('after_open', $after_open);
            if ('go_url' == $after_open) {
                $brocast->setPredefinedKeyValue('url', $url);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $brocast->setPredefinedKeyValue('production_mode', $this->production_mode);
            // [optional]Set extra fields
            $brocast->setExtraField('test', 'helloworld');
            //print("Sending broadcast notification, please wait...\r\n");
            return $brocast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendAndroidUnicast($device_tokens, $ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue('device_tokens', $device_tokens);
            $unicast->setPredefinedKeyValue('ticker', $ticker);
            $unicast->setPredefinedKeyValue('title', $title);
            $unicast->setPredefinedKeyValue('text', $text);
            $unicast->setPredefinedKeyValue('after_open', $after_open);
            if ('go_url' == $after_open) {
                $unicast->setPredefinedKeyValue('url', $url);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $unicast->setPredefinedKeyValue('production_mode', $this->production_mode);
            // Set extra fields
            $unicast->setExtraField('test', 'helloworld');
            //print("Sending unicast notification, please wait...\r\n");
            return $unicast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendAndroidFilecast($ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue('appkey', $this->appkey);
            $filecast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $filecast->setPredefinedKeyValue('ticker', $ticker);
            $filecast->setPredefinedKeyValue('title', $title);
            $filecast->setPredefinedKeyValue('text', $text);
            $filecast->setPredefinedKeyValue('after_open', $after_open);  //go to app
            if ('go_url' == $after_open) {
                $filecast->setPredefinedKeyValue('url', $url);
            }
            //print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents('aa'."\n".'bb');
            //print("Sending filecast notification, please wait...\r\n");
            return $filecast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendAndroidGroupcast($tag = array(), $ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            /*
              *  Construct the filter condition:
              *  "where":
              *	{
              *		"and":
              *		[
                *			{"tag":"test"},
                *			{"tag":"Test"}
              *		]
              *	}
              */
            $filter = array(
                            'where' => array(
                                            'and' => array(
                                                            $tag,
                                                         ),
                                        ),
                        );

            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue('appkey', $this->appkey);
            $groupcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue('filter', $filter);
            $groupcast->setPredefinedKeyValue('ticker', $ticker);
            $groupcast->setPredefinedKeyValue('title', $title);
            $groupcast->setPredefinedKeyValue('text', $text);
            $groupcast->setPredefinedKeyValue('after_open', $after_open);
            if ('go_url' == $after_open) {
                $groupcast->setPredefinedKeyValue('url', $url);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $groupcast->setPredefinedKeyValue('production_mode', $this->production_mode);
            //print("Sending groupcast notification, please wait...\r\n");
            return $groupcast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendAndroidCustomizedcast($alias, $alias_type = 'APP', $ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue('alias', $alias);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue('alias_type', $alias_type);
            $customizedcast->setPredefinedKeyValue('ticker', $ticker);
            $customizedcast->setPredefinedKeyValue('title', $title);
            $customizedcast->setPredefinedKeyValue('text', $text);
            $customizedcast->setPredefinedKeyValue('after_open', $after_open);
            if ('go_url' == $after_open) {
                $customizedcast->setPredefinedKeyValue('url', $url);
            }
            //print("Sending customizedcast notification, please wait...\r\n");
            return $customizedcast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendAndroidCustomizedcastFileId($content, $alias_type, $ticker, $title, $text, $after_open = 'go_app', $url = '')
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->uploadContents($content);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue('alias_type', $alias_type);
            $customizedcast->setPredefinedKeyValue('ticker', $title);
            $customizedcast->setPredefinedKeyValue('title', $title);
            $customizedcast->setPredefinedKeyValue('text', $text);
            $customizedcast->setPredefinedKeyValue('after_open', $after_open);
            if ('go_url' == $after_open) {
                $customizedcast->setPredefinedKeyValue('url', $url);
            }
            //print("Sending customizedcast notification, please wait...\r\n");
            return $customizedcast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}
