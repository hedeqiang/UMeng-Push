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

use Hedeqiang\UMeng\notification\ios\IOSBroadcast;
use Hedeqiang\UMeng\notification\ios\IOSCustomizedcast;
use Hedeqiang\UMeng\notification\ios\IOSFilecast;
use Hedeqiang\UMeng\notification\ios\IOSGroupcast;
use Hedeqiang\UMeng\notification\ios\IOSUnicast;

/**
 * Class IOS.
 */
class IOS
{
    protected $appkey = null;

    protected $appMasterSecret = null;

    protected $timestamp = null;

    protected $validation_token = null;

    protected $production_mode = false;

    public function __construct(array $config = [])
    {
        foreach ($config as $key => $val) {
            if ('appKey' == $key) {
                $this->appkey = $val;
            } elseif ('appMasterSecret' == $key) {
                $this->appMasterSecret = $val;
            } else {
                $this->timestamp = strval(time());
                $this->production_mode = $val;
            }
        }
    }

    /**
     * @param array $params
     * @param array $customized
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSBroadcast(array $params = [], array $customized = [])
    {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue('appkey', $this->appkey);
            $brocast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $brocast->setPredefinedKeyValue($key, $val);
            }
            if (count($customized)) {
                foreach ($customized as $key => $val) {
                    $brocast->setCustomizedField($key, $val);
                }
            }

            return $brocast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $params
     * @param array $customized
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSUnicast(array $params = [], array $customized = [])
    {
        try {
            $unicast = new IOSUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $unicast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $unicast->setPredefinedKeyValue($key, $val);
            }
            if (count($customized)) {
                foreach ($customized as $key => $val) {
                    $unicast->setCustomizedField($key, $val);
                }
            }

            return $unicast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $params
     * @param null  $content
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSFilecast(array $params = [], $content = null)
    {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue('appkey', $this->appkey);
            $filecast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $filecast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $filecast->setPredefinedKeyValue($key, $val);
            }

            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents($content);

            return $filecast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $filter
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSGroupcast(array $filter = [], array $params = [])
    {
        try {
            /*
              *  Construct the filter condition:
              *  "where":
              *	{
              *		"and":
              *		[
                *			{"tag":"iostest"}
              *		]
              *	}
              */

            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue('appkey', $this->appkey);
            $groupcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $groupcast->setPredefinedKeyValue('production_mode', $this->production_mode);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue('filter', $filter);

            foreach ($params as $key => $val) {
                $groupcast->setPredefinedKeyValue($key, $val);
            }

            return $groupcast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSCustomizedcast(array $params = [])
    {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue('production_mode', $this->production_mode);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            foreach ($params as $key => $val) {
                $customizedcast->setPredefinedKeyValue($key, $val);
            }

            return $customizedcast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }


    /**
     * @param array $params
     * @param null $content
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendIOSCustomizedcastFileId(array $params = [], $content = null)
    {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue('production_mode', $this->production_mode);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.

            $customizedcast->uploadContents($content);

            foreach ($params as $key => $val) {
                $customizedcast->setPredefinedKeyValue($key, $val);
            }

            return $customizedcast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

}
