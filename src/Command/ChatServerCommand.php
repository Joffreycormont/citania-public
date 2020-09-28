<?php
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ratchet\Server\IoServer;
use App\Server\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ChatServerCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('afsy:app:chat-server')
            ->setDescription('Start chat server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            new HttpServer(new WsServer(new Chat())),
            8080,
            '127.0.0.1'
        );
        $server->run();
    }
}