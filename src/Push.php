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

use Hedeqiang\UMeng\Traits\HasHttpRequest;

class Push
{
    use HasHttpRequest;

    //  消息发送
    const ENDPOINT_TEMPLATE_SEND = 'https://msgapi.umeng.com/api/send';
    // 任务类消息状态查询
    const ENDPOINT_TEMPLATE_STATUS = 'https://msgapi.umeng.com/api/status';
    // 任务类消息取消
    const ENDPOINT_TEMPLATE_CANCEL = 'https://msgapi.umeng.com/api/cancel';
    // 文件上传
    const ENDPOINT_TEMPLATE_UPLOAD = 'https://msgapi.umeng.com/upload';

    protected $config;

    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * 消息发送
     *
     * @param array $params
     *
     * @return mixed
     */
    public function send($params = []): array
    {
        list($url, $params) = $this->getUrl($params, 'send');

        return $this->curl($url, $params);
    }

    /**
     * 任务类消息状态查询.
     *
     * @return mixed
     */
    public function status(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'status');

        return $this->curl($url, $params);
    }

    /**
     * 任务类消息取消.
     *
     * @return mixed
     */
    public function cancel(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'cancel');

        return $this->curl($url, $params);
    }

    /**
     * 文件上传.
     *
     * @return mixed
     */
    public function upload(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'upload');

        return $this->curl($url, $params);
    }

    /**
     * Build endpoint url.
     */
    protected function buildEndpoint(array $body, string $type): string
    {
        $body = json_encode($body, true);
        switch ($type) {
            case 'send':
                return $this->getSign(self::ENDPOINT_TEMPLATE_SEND, $body);
            case 'status':
                return $this->getSign(self::ENDPOINT_TEMPLATE_STATUS, $body);
            case 'cancel':
                return $this->getSign(self::ENDPOINT_TEMPLATE_CANCEL, $body);
            case 'upload':
                return $this->getSign(self::ENDPOINT_TEMPLATE_UPLOAD, $body);
        }
    }

    /**
     * @param $body
     */
    protected function getSign(string $endpoint, $body): string
    {
        switch ($this->config->get('deviceType')) {
            case 'Android':
                $sign = md5('POST'.$endpoint.$body.$this->config->get('Android.appMasterSecret'));

                return $endpoint.'?sign='.$sign;
            case 'iOS':
                $sign = md5('POST'.$endpoint.$body.$this->config->get('iOS.appMasterSecret'));

                return $endpoint.'?sign='.$sign;
//            case 'All':
//                $android_sign = md5('POST' . $endpoint . $body . $this->config->get('Android.appMasterSecret'));
//                $ios_sign = md5('POST' . $endpoint . $body . $this->config->get('iOS.appMasterSecret'));
//                return $endpoint . '?sign=' . $android_sign;
        }
    }

    /**
     * 获取 URL 和参数.
     */
    protected function getUrl(array $params, string $type): array
    {
        if (!array_key_exists('appKey', $params)) {
            switch ($this->config->get('deviceType')) {
                case 'Android':
                    $params['appkey'] = $this->config->get('Android.appKey');
                    break;
                case 'iOS':
                    $params['appkey'] = $this->config->get('iOS.appKey');
                    break;
            }
        }

        if (!array_key_exists('timestamp', $params)) {
            $params['timestamp'] = time();
        }

        return [$this->buildEndpoint($params, $type), $params];
    }

    /**
     * @param $url
     * @param $params
     *
     * @return array|mixed
     */
    protected function curl(string $url, $params): array
    {
        try {
            $response = $this->postJson($url, $params);
        } catch (\Exception $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return json_decode($responseBodyAsString, true);
        }

        return json_decode((string) $response, true);
    }
}
