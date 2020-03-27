<?php
namespace zhaolm\phpfcm\Recipient;

class Topic implements Recipient
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getIdentifier()
    {
        return $this->name;
    }
}