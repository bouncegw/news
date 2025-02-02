<?php

namespace App\Message;

class SendChannelMessage
{
    public function __construct(public string $channelUrl) {
    }
}