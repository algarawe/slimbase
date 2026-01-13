<?php
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

return [
    LoggerInterface::class => function (ContainerInterface $c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger('app');
        
        // We go UP one level from /config to find the /logs folder
        $logPath = $settings['path']; 
        //__DIR__ . '/../logs/app.log';
        
        $handler = new StreamHandler($logPath,  $settings['level']);
        $logger->pushHandler($handler);
        
        return $logger;
    },
];