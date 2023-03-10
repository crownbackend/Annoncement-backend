<?php

namespace App\Command;

use App\Websocket\MessageHandler;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:websocket-serve',
    description: 'Add a short description for your command',
)]
class WebsocketServeCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $port = 3001;

        $io = new SymfonyStyle($input, $output);
        $io->success('websocket serve start on port : ' . $port);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageHandler()
                )
            ),
            $port
        );

        $server->run();

        return Command::SUCCESS;
    }
}
