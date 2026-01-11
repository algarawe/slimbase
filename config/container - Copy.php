<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface; // Added
use Slim\Factory\AppFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use DI\ContainerBuilder; // Added


// Create the container builder
$builder = new ContainerBuilder(); // Updated to use the use statement
$builder->useAutowiring(true);

$builder->addDefinitions([
    // Here is the magic: Map the Interface to the concrete implementation
    LoggerInterface::class => function (ContainerInterface $c) {
        $logger = new Logger('app_logger');
        $logPath = __DIR__ . '/../logs/app.log'; 
        // Configure file output
        $handler = new StreamHandler($logPath,  \Monolog\Level::Debug);
        //$logger->pushHandler(new StreamHandler($logPath, \Monolog\Level::Debug));
        $logger->pushHandler($handler);
        return $logger;
    },
]);

$container = $builder->build();

// Set the container on Slim
AppFactory::setContainer($container);
return $container;