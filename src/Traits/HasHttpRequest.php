<?php

/*
 * This file is part of the hedeqiang/umeng.
 *
 * (c) hedeqiang <laravel_code@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hedeqiang\UMeng\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HasHttpRequest.
 */
trait HasHttpRequest
{

    /**
     * Make a get request.
     *
     * @param  string  $endpoint
     * @param  array   $query
     * @param  array   $headers
     *
     * @return array
     */
    protected function get(string $endpoint, array $query = [], array $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query'   => $query,
        ]);
    }

    /**
     * Make a post request.
     *
     * @param  string  $endpoint
     * @param          $options
     * @param  array   $headers
     *
     * @return array
     */
    protected function post(string $endpoint, $options, array $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers'   => $headers,
            'multipart' => $options,
        ]);
    }

    /**
     * Make a post request with json params.
     *
     * @param       $endpoint
     * @param  array  $params
     * @param  array  $headers
     *
     * @return array
     */
    protected function postJson($endpoint, array $params = [], array $headers = []): array
    {
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'json'    => $params,
        ]);
    }

    /**
     * @param $endpoint
     * @param  array  $headers
     * @param  array  $query
     *
     * @return array
     */
    protected function delete($endpoint, array $headers = [], array $query = []): array
    {
        return $this->request('delete', $endpoint, [
            'headers' => $headers,
            'query'   => $query,
        ]);
    }

    /**
     * @param $endpoint
     * @param $params
     * @param  array  $headers
     *
     * @return array
     */
    protected function put($endpoint, $params, array $headers = []): array
    {
        return $this->request('put', $endpoint, [
            'headers' => $headers,
            'json'    => $params,
        ]);
    }

    /**
     * Make a http request.
     *
     * @param  array  $options  http://docs.guzzlephp.org/en/latest/request-options.html
     *
     * @return array
     */
    protected function request(string $method, string $endpoint, array $options = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
    }

    /**
     * Return base Guzzle options.
     *
     * @return array
     */
    protected function getBaseOptions()
    {
        return [
            'base_uri' => method_exists($this, 'getBaseUri') ? $this->getBaseUri() : '',
            'timeout'  => method_exists($this, 'getTimeout') ? $this->getTimeout() : 10.0,
        ];
    }

    /**
     * Return http client.
     *
     * @param  array  $options
     *
     * @return Client
     *
     * @codeCoverageIgnore
     */
    protected function getHttpClient(array $options = []): Client
    {
        return new Client($options);
    }

    /**
     * Convert response contents to json.
     *
     * @return ResponseInterface|array|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();
        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }

        return $contents;
    }
}
