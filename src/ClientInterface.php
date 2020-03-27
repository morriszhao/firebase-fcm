<?php

namespace zhaolm\phpfcm;


interface ClientInterface
{


    /**
     * @param $apiKey
     * @return mixed
     */
    public function setApiKey($apiKey);

    /**
     * @param $url
     * @return mixed
     */
    public function setProxyApiUrl($url);

    /**
     * @param Message $message
     * @return mixed
     */
    public function send(Message $message);

}
