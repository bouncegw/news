<?php

namespace App\Command;

use App\Message\SendChannelMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:parse-news-channel',
    description: 'Команда парсит новости с новостных каналов ',
)]
class ParseNewsChannelCommand extends Command
{
    private const CHANNEL_URLS = [
        'https://lenta.ru/rss',
        'https://ria.ru/export/rss2/archive/index.xml'
    ];

    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach (self::CHANNEL_URLS as $url) {
            try {
                $message = new SendChannelMessage($url, 'parse_news');
                $this->bus->dispatch($message);
                $io->success("Сообщение для $url отправлено в очередь.");
            } catch (\Exception $exception) {
                $io->error("Ошибка: " . $exception->getMessage());
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
