<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\notification;

abstract class IOSNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $iosPayload = [
        'aps' => [
            'alert' => null,
            //"badge"				=>  xx,
            //"sound"				=>	"xx",
            //"content-available"	=>	xx
        ],
        //"key1"	=>	"value1",
        //"key2"	=>	"value2"
    ];

    // Keys can be set in the aps level
    //protected $APS_KEYS    = array("alert",'title','subtitle','body', "badge", "sound", "content-available");
    protected $APS_KEYS = ['alert', 'title', 'badge', 'sound', 'content-available'];

    public function __construct()
    {
        parent::__construct();
        $this->data['payload'] = $this->iosPayload;
    }

    // Set key/value for $data array, for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
    public function setPredefinedKeyValue($key, $value)
    {
        if (!is_string($key)) {
            throw new \Exception('key should be a string!');
        }
        if (in_array($key, $this->DATA_KEYS)) {
            $this->data[$key] = $value;
        } elseif (in_array($key, $this->APS_KEYS)) {
            $this->data['payload']['aps'][$key] = $value;
        } elseif (in_array($key, $this->POLICY_KEYS)) {
            $this->data['policy'][$key] = $value;
        } else {
            if ('payload' == $key || 'policy' == $key || 'aps' == $key) {
                throw new \Exception("You don't need to set value for ${key} , just set values for the sub keys in it.");
            } else {
                throw new \Exception("Unknown key: ${key}");
            }
        }
    }

    // Set extra key/value for Android notification
    public function setCustomizedField($key, $value)
    {
        if (!is_string($key)) {
            throw new \Exception('key should be a string!');
        }
        $this->data['payload'][$key] = $value;
    }
}
