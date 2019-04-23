<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\notification\android;

use GuzzleHttp\Client;
use Hedeqiang\UMeng\notification\AndroidNotification;
use Hedeqiang\UMeng\Exceptions\HttpException;

class AndroidFilecast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'filecast';
        $this->data['file_id'] = null;
    }

    //return file_id if SUCCESS, else throw Exception with details.
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
        $post = array(
            'appkey' => $this->data['appkey'],
            'timestamp' => $this->data['timestamp'],
            'content' => $content,
        );
        $url = $this->host.$this->uploadPath;
        $postBody = json_encode($post);
        $sign = md5('POST'.$url.$postBody.$this->appMasterSecret);
        $url = $url.'?sign='.$sign;

        try {
            $client = new Client();
            $response = $client->request('POST', $url, [
                'body' => $postBody,
            ]); //echo  $xml;
            $data = \json_decode($response->getBody()->getContents(), true);

            $this->data['file_id'] = $data['data']['file_id'];
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
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
