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

abstract class AndroidNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $androidPayload = [
        'display_type' => 'notification',
        'body' => [
            'ticker' => null,
            'title' => null,
            'text' => null,
            //"icon"       => "xx",
            //largeIcon    => "xx",
            'play_vibrate' => 'true',
            'play_lights' => 'true',
            'play_sound' => 'true',
            'after_open' => null,
            //"url"        => "xx",
            //"activity"   => "xx",
            //custom       => "xx"

            //'extra' => [],
        ],
    ];

    // Keys can be set in the payload level
    protected $PAYLOAD_KEYS = ['display_type'];

    // Keys can be set in the body level
    protected $BODY_KEYS = [
        'ticker', 'title', 'text', 'builder_id', 'icon', 'largeIcon', 'img', 'sound', 'play_vibrate', 'play_lights', 'play_sound', 'after_open', 'url',
        'activity', 'custom',
    ];

    // Keys can be set in the minpush, mi_activity
    protected $MIPUSH_KEYS = [
        'mipush', 'mi_activity'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data['payload'] = $this->androidPayload;
    }

    // Set key/value for $data array, for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
    public function setPredefinedKeyValue($key, $value)
    {
        if (!is_string($key)) {
            throw new \Exception('key should be a string!');
        }
        if (in_array($key, $this->DATA_KEYS)) {
            $this->data[$key] = $value;
        } elseif (in_array($key, $this->PAYLOAD_KEYS)) {
            $this->data['payload'][$key] = $value;
            if ('display_type' == $key && 'message' == $value) {
                $this->data['payload']['body']['ticker'] = '';
                $this->data['payload']['body']['title'] = '';
                $this->data['payload']['body']['text'] = '';
                $this->data['payload']['body']['after_open'] = '';
                if (!array_key_exists('custom', $this->data['payload']['body'])) {
                    $this->data['payload']['body']['custom'] = null;
                }
            }
        } elseif (in_array($key, $this->BODY_KEYS)) {
            $this->data['payload']['body'][$key] = $value;
            if ('after_open' == $key && 'go_custom' == $value && !array_key_exists('custom', $this->data['payload']['body'])) {
                $this->data['payload']['body']['custom'] = null;
            }
        } elseif (in_array($key, $this->POLICY_KEYS)) {
            $this->data['policy'][$key] = $value;
        } elseif (in_array($key, $this->MIPUSH_KEYS)) {
            $this->data[$key] = $value;
        } else {
            if ('payload' == $key || 'body' == $key || 'policy' == $key || 'extra' == $key) {
                throw new \Exception("You don't need to set value for ${key} , just set values for the sub keys in it.");
            } else {
                throw new \Exception("Unknown key: ${key}");
            }
        }
    }

    // Set extra key/value for Android notification
    public function setExtraField($key, $value)
    {
        if (!is_string($key)) {
            throw new \Exception('key should be a string!');
        }
        $this->data['payload']['extra'][$key] = $value;
    }
}
