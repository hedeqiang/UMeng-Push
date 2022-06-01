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

use Exception;
use Hedeqiang\UMeng\Traits\HasHttpRequest;

class IOS implements PushInterface
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

    /**
     * Android constructor.
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * 消息发送
     */
    public function send(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'send');

        return $this->curl($url, $params);
    }

    /**
     * 任务类消息状态查询.
     */
    public function status(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'status');

        return $this->curl($url, $params);
    }

    /**
     * 任务类消息取消.
     */
    public function cancel(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'cancel');

        return $this->curl($url, $params);
    }

    /**
     * 文件上传.
     */
    public function upload(array $params): array
    {
        list($url, $params) = $this->getUrl($params, 'upload');

        return $this->curl($url, $params);
    }

    /**
     * 返回 代签名的 Url.
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
            default:
                break;
        }
    }

    /**
     * 生成签名.
     *
     * @param $body
     */
    protected function getSign(string $endpoint, $body): string
    {
        $sign = md5('POST'.$endpoint.$body.$this->config->get('iOS.appMasterSecret'));

        return $endpoint.'?sign='.$sign;
    }

    /**
     * 获取 URL 和参数.
     */
    protected function getUrl(array $params, string $type): array
    {
        if (!array_key_exists('timestamp', $params)) {
            $params['timestamp'] = time();
        }
        if (!array_key_exists('production_mode', $params)) {
            $params['production_mode'] = $this->config->get('iOS.productionMode');
        }

        if (!array_key_exists('appKey', $params)) {
            $params['appkey'] = $this->config->get('iOS.appKey');
        }

        return [$this->buildEndpoint($params, $type), $params];
    }

    /**
     * @param $params
     */
    protected function curl(string $url, $params): array
    {
        try {
            $response = $this->postJson($url, $params);
        } catch (Exception $e) {
            if ($response = $e->getResponse()) {
                $responseBodyAsString = (string) $response->getBody();

                return json_decode($responseBodyAsString, true);
            }

            return ['ret' => 'FAIL', 'data' => ['error_msg' => $e->getMessage(), 'error_code' => (string) $e->getCode()]];
        }

        return json_decode((string) $response, true);
    }
}
