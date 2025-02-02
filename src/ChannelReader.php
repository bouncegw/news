<?php

namespace App;

use App\Message\CreateNewsMessage;
use DOMDocument;
use Symfony\Component\Messenger\MessageBusInterface;
use XMLReader;

class ChannelReader
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    //Парсим частями новости и отправляем сообщения в rmq
    public function reader(string $channelUrl): void
    {
        $reader = new XMLReader();
        $reader->open($channelUrl);
        while ($reader->read()) {
            try{
                if ($reader->nodeType == XMLReader::ELEMENT && $reader->localName == 'item') {
                    $dom = new DOMDocument();
                    $node = simplexml_import_dom($dom->importNode($reader->expand(), true));

                    $this->sendMessageForCreateNews($channelUrl, $node->title, $node->category, $node->pubDate);
                }
            }catch (\Exception $exception){
                //какая то обаботка ошибок, запись в лог
            }

        }

        $reader->close();
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function sendMessageForCreateNews(string $channelUrl, string $title, string $category, string $date): void
    {
        $message = new CreateNewsMessage(
            channelUrl: $channelUrl,
            title: $title,
            category: $category,
            date: new \DateTimeImmutable($date));

        $this->bus->dispatch($message);
    }
}