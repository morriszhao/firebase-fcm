<?php

namespace zhaolm\phpfcm;


use JsonSerializable;

class TopicOption implements JsonSerializable
{
    protected $topicName;
    protected $device = array();


    public function __construct($topicName)
    {
        $this->topicName = $topicName;
    }

    public function addDevice($device)
    {
        if (is_string($device)) {
            $this->device[] = $device;
        }

        if (is_array($device)) {
            $this->device = array_merge($this->device, $device);
        }
    }


    public function getSubscribeUrl()
    {
        return 'https://iid.googleapis.com/iid/v1:batchAdd';
    }

    public function getUnSubscribeUrl()
    {
        return 'https://iid.googleapis.com/iid/v1:batchRemove';
    }


    public function jsonSerialize()
    {
        return [
            'to' => "/topics/" . $this->topicName,
            'registration_tokens' => $this->device,
        ];
    }


}