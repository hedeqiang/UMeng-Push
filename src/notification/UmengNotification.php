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

abstract class UmengNotification
{
    // The host
    protected $host = 'http://msg.umeng.com';

    // The upload path
    protected $uploadPath = '/upload';

    // The post path
    protected $postPath = '/api/send';

    // The app master secret
    protected $appMasterSecret = null;

    /*
     * $data is designed to construct the json string for POST request. Note:
     * 1)The key/value pairs in comments are optional.
     * 2)The value for key 'payload' is set in the subclass(AndroidNotification or IOSNotification), as their payload structures are different.
     */
    protected $data = array(
            'appkey' => null,
            'timestamp' => null,
            'type' => null,
            //"device_tokens"  => "xx",
            //"alias"          => "xx",
            //"file_id"        => "xx",
            //"filter"         => "xx",
            //"policy"         => array("start_time" => "xx", "expire_time" => "xx", "max_send_num" => "xx"),
            'production_mode' => 'true',
            //"feedback"       => "xx",
            //"description"    => "xx",
            //"thirdparty_id"  => "xx"
    );

    protected $DATA_KEYS = array('appkey', 'timestamp', 'type', 'device_tokens', 'alias', 'alias_type', 'file_id', 'filter', 'production_mode',
                                    'feedback', 'description', 'thirdparty_id', );

    protected $POLICY_KEYS = array('start_time', 'expire_time', 'max_send_num');

    public function __construct()
    {
    }

    public function setAppMasterSecret($secret)
    {
        $this->appMasterSecret = $secret;
    }

    //return TRUE if it's complete, otherwise throw exception with details
    public function isComplete()
    {
        if (is_null($this->appMasterSecret)) {
            throw new \Exception('Please set your app master secret for generating the signature!');
        }
        $this->checkArrayValues($this->data);

        return true;
    }

    private function checkArrayValues($arr)
    {
        foreach ($arr as $key => $value) {
            if (is_null($value)) {
                throw new \Exception($key.' is NULL!');
            } elseif (is_array($value)) {
                $this->checkArrayValues($value);
            }
        }
    }

    // Set key/value for $data array, for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
    abstract public function setPredefinedKeyValue($key, $value);

    //send the notification to umeng, return response data if SUCCESS , otherwise throw Exception with details.
    public function send()
    {
        //check the fields to make sure that they are not NULL
        $this->isComplete();

        $url = $this->host.$this->postPath;
        $postBody = json_encode($this->data);
        $sign = md5('POST'.$url.$postBody.$this->appMasterSecret);
        $url = $url.'?sign='.$sign;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = curl_error($ch);
        curl_close($ch);
        echo $result."\r\n";
        if ('0' == $httpCode) {
            // Time out
//            return [
//                'Curl_error_number' => $curlErrNo,
//                'Curl_error_details' => $curlErr
//            ];
            throw new \Exception('Curl error number:'.$curlErrNo.' , Curl error details:'.$curlErr."\r\n");
        } elseif ('200' != $httpCode) {
            // We did send the notifition out and got a non-200 response
//            return [
//                'Http_code' => $httpCode,
//                'details' => $result .'\r\n',
//                ];
            throw new \Exception('Http code:'.$httpCode.' details:'.$result."\r\n");
        } else {
            return $result;
        }
    }
}
