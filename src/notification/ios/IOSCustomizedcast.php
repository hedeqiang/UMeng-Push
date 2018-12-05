<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\notification\ios;

use Hedeqiang\UMeng\notification\IOSNotification;

class IOSCustomizedcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'customizedcast';
        $this->data['alias_type'] = null;
    }

    public function isComplete()
    {
        parent::isComplete();
        if (!array_key_exists('alias', $this->data) && !array_key_exists('file_id', $this->data)) {
            throw new \Exception('You need to set alias or upload file for customizedcast!');
        }
    }

    // Upload file with device_tokens or alias to Umeng
    public function uploadContents($content)
    {
        if (null == $this->data['appkey']) {
            throw new \Exception('appkey should not be NULL!');
        }
        if (null == $this->data['timestamp']) {
            throw new \Exception('timestamp should not be NULL!');
        }
        if (!is_string($content)) {
            throw new \Exception('content should be a string!');
        }
        $post = array('appkey' => $this->data['appkey'],
                      'timestamp' => $this->data['timestamp'],
                      'content' => $content,
                      );
        $url = $this->host.$this->uploadPath;
        $postBody = json_encode($post);
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
        if ('0' == $httpCode) { //time out
            throw new \Exception('Curl error number:'.$curlErrNo.' , Curl error details:'.$curlErr."\r\n");
        } elseif ('200' != $httpCode) { //we did send the notifition out and got a non-200 response
            throw new Exception('http code:'.$httpCode.' details:'.$result."\r\n");
        }
        $returnData = json_decode($result, true);
        if ('FAIL' == $returnData['ret']) {
            throw new \Exception('Failed to upload file, details:'.$result."\r\n");
        } else {
            $this->data['file_id'] = $returnData['data']['file_id'];
        }
    }

    public function getFileId()
    {
        if (array_key_exists('file_id', $this->data)) {
            return $this->data['file_id'];
        }

        return null;
    }
}
