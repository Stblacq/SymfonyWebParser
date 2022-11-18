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
use App\Command\GetArticleCommand;
use Symfony\Component\DomCrawler\Crawler;


#[AsCommand(
    name: 'parse-articles',
    description: 'parses articles from a queue',
)]
class ParseArticlesCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('url', InputArgument::REQUIRED, 'Url to scrape ');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $this->handleQueue($url);
        $io->success('Url scrapped successfully. Content Length:'.strlen($html));
        return Command::SUCCESS;
    }

    private  function handleQueue($channelName)
    {
        
        $callback =  function ($msg) { $this->parseHtml($msg->body); } ;

        $rClient = new RabbitMqClient("rabbitmq",5672,"guest","guest");
        $res =$rClient->receive($channelName,$callback);
    }

    private function parseHtml($html)
    {

        $crawler = new Crawler($html);

        $articles = $crawler->filter('body > div.lenta-item')
        ->each(function (Crawler $node, $i) { ## TODO CONVERT HTML TO ARTICLES

        });
       
    }

}
