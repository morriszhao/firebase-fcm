<?php

namespace zhaolm\phpfcm;


/**
 * @link https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support
 */
class Notification implements \JsonSerializable
{
    private $title;
    private $body;
    private $badge;
    private $icon;
    private $color;
    private $sound;
    private $clickAction;
    private $tag;
    private $image;


    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param $badge
     * @return $this
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
        return $this;
    }

    /**
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @param $actionName
     * @return $this
     */
    public function setClickAction($actionName)
    {
        $this->clickAction = $actionName;
        return $this;
    }

    /**
     * @param $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @param $sound
     * @return $this
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    public function jsonSerialize()
    {
        $jsonData = array(
            'title' => $this->title,
            'body' => $this->body
        );
        if ($this->badge) {
            $jsonData['badge'] = $this->badge;
        }
        if ($this->icon) {
            $jsonData['icon'] = $this->icon;
        }
        if ($this->clickAction) {
            $jsonData['click_action'] = $this->clickAction;
        }
        if ($this->sound) {
            $jsonData['sound'] = $this->sound;
        }
        if ($this->color) {
            $jsonData['color'] = $this->color;
        }
        if ($this->tag) {
            $jsonData['tag'] = $this->tag;
        }

        if ($this->image) {
            $jsonData['image'] = $this->image;
        }
        return $jsonData;
    }
}