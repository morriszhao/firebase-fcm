<?php

namespace zhaolm\phpfcm;

use GuzzleHttp;

class Client implements ClientInterface
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';
//    const DEFAULT_API_URL = 'https://fcm.googleapis.com/v1/projects/myproject-h5-notitication-test/messages:send';

    /** @var string */
    private $apiKey;

    /** @var string */
    private $proxyApiUrl;

    /** @var GuzzleHttp\ClientInterface */
    private $guzzleClient;

    public function injectHttpClient(GuzzleHttp\ClientInterface $client)
    {
        $this->guzzleClient = $client;
    }


    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }


    public function setProxyApiUrl($url)
    {
        $this->proxyApiUrl = $url;
        return $this;
    }


    public function send($message)
    {
        return $this->guzzleClient->post(
            $this->getApiUrl(),
            [
                'headers' => [
                    'Authorization' => sprintf('key=%s', $this->apiKey),
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($message)
            ]
        );
    }

    private function getApiUrl()
    {
        return isset($this->proxyApiUrl) ? $this->proxyApiUrl : self::DEFAULT_API_URL;
    }
}