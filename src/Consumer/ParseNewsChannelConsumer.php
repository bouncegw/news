<?php

namespace App\Consumer;

use App\ChannelReader;
use App\Message\SendChannelMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ParseNewsChannelConsumer
{
    public function __construct(readonly private ChannelReader $channelReader)
    {
    }

    public function __invoke(SendChannelMessage $message): void
    {
        $this->channelReader->read($message->channelUrl);
    }
}