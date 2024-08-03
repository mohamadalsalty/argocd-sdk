<?php

namespace Alsalty\Argocd\Helpers;

/**
 *
 */
class Curl
{
    /**
     * @param $url
     * @param $payload
     * @param array $headers
     * @param bool $ignoreSSL
     * @return array
     */
    public static function post($url, $payload, array $headers = [], bool $ignoreSSL = false): array
    {
        return self::request('POST', $url, $headers, $payload, $ignoreSSL);
    }

    /**
     * @param $url
     * @param array $headers
     * @param bool $ignoreSSL
     * @return array
     */
    public static function get($url, array $headers = [], bool $ignoreSSL = false): array
    {
        return self::request('GET', $url, $headers, null, $ignoreSSL);
    }

    /**
     * @param $method
     * @param $url
     * @param array $headers
     * @param $payload
     * @param bool $ignoreSSL
     * @return array
     */
    private static function request($method, $url, array $headers = [], $payload = null, bool $ignoreSSL = false): array
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if ($ignoreSSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        } elseif ($method === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        curl_close($ch);

        $responseData = json_decode($body, true);

        return [
            'httpCode' => $httpCode,
            'headers' => $headers,
            'body' => $responseData,
        ];
    }
}
