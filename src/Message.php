<?php

namespace zhaolm\phpfcm;


use zhaolm\phpfcm\Recipient\Recipient;
use zhaolm\phpfcm\Recipient\Topic;
use zhaolm\phpfcm\Recipient\Device;


class Message implements \JsonSerializable
{
    const PRIORITY_HIGH = 'high',
        PRIORITY_NORMAL = 'normal';

    private $notification;
    private $collapseKey;


    private $priority = self::PRIORITY_HIGH;
    private $data;
    /** @var Recipient[] */
    private $recipients = array();
    private $recipientType;
    private $timeToLive;
    private $delayWhileIdle;
    private $options;

    /**
     * @param Recipient $recipient
     * @return $this
     */
    public function addRecipient(Recipient $recipient)
    {
        if (!$recipient instanceof Device && !$recipient instanceof Topic) {
            throw new \UnexpectedValueException('currently phpFCM only supports topic and single device messages');
        }

        if (!isset($this->recipientType)) {
            $this->recipientType = get_class($recipient);
        }

        if ($this->recipientType !== get_class($recipient)) {
            throw new \InvalidArgumentException('mixed recepient types are not supported by FCM');
        }

        $this->recipients[] = $recipient;
        return $this;
    }

    public function setNotification(Notification $notification)
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * @param $collapseKey
     * @return $this
     */
    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;
        return $this;
    }

    /**
     * @param $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param $ttl
     * @return $this
     */
    public function setTimeToLive($ttl)
    {
        $this->timeToLive = $ttl;

        return $this;
    }

    /**
     * @param $delayWhileIdle
     * @return $this
     */
    public function setDelayWhileIdle($delayWhileIdle)
    {
        $this->delayWhileIdle = $delayWhileIdle;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function jsonSerialize()
    {
        $jsonData = array();

        if (empty($this->recipients)) {
            throw new \UnexpectedValueException('message must have at least one recipient');
        }

        $this->createTo($jsonData);
        if ($this->collapseKey) {
            $jsonData['collapse_key'] = $this->collapseKey;
        }
        if ($this->data) {
            $jsonData['data'] = $this->data;
        }
        if ($this->priority) {
            $jsonData['priority'] = $this->priority;
        }
        if ($this->notification) {
            $jsonData['notification'] = $this->notification;
        }
        if ($this->timeToLive) {
            $jsonData['time_to_live'] = (int)$this->timeToLive;
        }
        if ($this->delayWhileIdle) {
            $jsonData['delay_while_idle'] = (bool)$this->delayWhileIdle;
        }
        if ($this->options) {
            $jsonData['webpush']['fcm_options'] = $this->options;
        }

        return $jsonData;
    }

    public function setOptions(array $optinos)
    {
        $this->options = $optinos;
    }

    private function createTo(array &$jsonData)
    {
        switch ($this->recipientType) {
            case Topic::class:
                if (count($this->recipients) > 1) {
                    $topics = array_map(
                        function (Topic $topic) {
                            return sprintf("'%s' in topics", $topic->getIdentifier());
                        },
                        $this->recipients
                    );
                    $jsonData['condition'] = implode(' || ', $topics);
                    break;
                }
                $jsonData['to'] = sprintf('/topics/%s', current($this->recipients)->getIdentifier());
                break;
            default:
                if (count($this->recipients) === 1) {
                    $jsonData['to'] = current($this->recipients)->getIdentifier();
                } elseif (count($this->recipients) > 1) {
                    $jsonData['registration_ids'] = array();

                    foreach ($this->recipients as $recipient) {
                        $jsonData['registration_ids'][] = $recipient->getIdentifier();
                    }
                }
        }
    }
}