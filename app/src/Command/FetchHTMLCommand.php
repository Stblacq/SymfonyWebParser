<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Client\RabbitMqClient;
use App\Client\WebScrapper;


#[AsCommand(
    name: 'fetch-html',
    description: 'Scrapes a url to fetch html',
)]
class FetchHTMLCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('url', InputArgument::REQUIRED, 'Url to scrape ');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $html = WebScrapper::getHtml($url);
        $this->sendToRabbitMq($html,$url);
        $io->success('Url scrapped successfully. Content Length:'.strlen($html));
        return Command::SUCCESS;
    }

    private function sendToRabbitMq($html,$channelName){
        $rClient = new RabbitMqClient("rabbitmq",5672,"guest","guest");
        $rClient->send($channelName,$html);
    }
}
