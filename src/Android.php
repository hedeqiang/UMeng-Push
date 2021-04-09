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
use Hedeqiang\UMeng\notification\android\AndroidListcast;
use Hedeqiang\UMeng\notification\android\AndroidUnicast;

/**
 * Class Android.
 */
class Android
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
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidBroadcast(array $params = [], array $extra = [])
    {
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue('appkey', $this->appkey);
            $brocast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $brocast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $brocast->setPredefinedKeyValue($key, $val);
            }
            if (count($extra)) {
                foreach ($extra as $key => $val) {
                    $brocast->setExtraField($key, $val);
                }
            }

            return $brocast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidUnicast(array $params = [], array $extra = [])
    {
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $unicast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $unicast->setPredefinedKeyValue($key, $val);
            }
            if (count($extra)) {
                foreach ($extra as $key => $val) {
                    $unicast->setExtraField($key, $val);
                }
            }

            return $unicast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param null $content
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidFilecast(array $params = [], $content = null)
    {
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue('appkey', $this->appkey);
            $filecast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $filecast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $filecast->setPredefinedKeyValue($key, $val);
            }

            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents($content);

            return $filecast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidGroupcast(array $filter = [], array $params = [])
    {
        try {
            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue('appkey', $this->appkey);
            $groupcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $groupcast->setPredefinedKeyValue('production_mode', $this->production_mode);

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
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidCustomizedcast(array $params = [])
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $customizedcast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $customizedcast->setPredefinedKeyValue($key, $val);
            }

            return $customizedcast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param null $content
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidCustomizedcastFileId(array $params = [], $content = null)
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);

            $customizedcast->uploadContents($content);

            foreach ($params as $key => $val) {
                $customizedcast->setPredefinedKeyValue($key, $val);
            }

            return $customizedcast->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function sendAndroidListcast(array $params = [])
    {
        try {
            $unicast = new AndroidListcast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $unicast->setPredefinedKeyValue('production_mode', $this->production_mode);

            foreach ($params as $key => $val) {
                $unicast->setPredefinedKeyValue($key, $val);
            }

            return $unicast->send();
            //print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}
