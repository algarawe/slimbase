<?php
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

// Define the base path of the project (one level up from public)
define('APP_ROOT', __DIR__);
require APP_ROOT . '/vendor/autoload.php';
//require __DIR__ . '/vendor/autoload.php';
// 1. Initialize ContainerBuilder
$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/config/settings.php');
// 2. Load your definitions from the config folder
$containerBuilder->addDefinitions(__DIR__ . '/config/container.php');

// 3. Build the Container and give it to Slim
$container = $containerBuilder->build();
AppFactory::setContainer($container);
$app = AppFactory::create();

 
 
//$app->addErrorMiddleware(true, true, true, $logger);
$app->addErrorMiddleware(true, true, true, $container->get(LoggerInterface::class));
// 4. Use the Logger in a Route

// 2. Register Routes
//$routes = require __DIR__ . '/routes/route.php';
$routes = require __DIR__ . '/src/routes/route.php';
$routes($app);

// $app->get('/', function (Request $request, Response $response) {
//     // Inside a closure, $this is the Container
//     $logger = $this->get(LoggerInterface::class);
    
//     $logger->info("Log test successful from the route!");

//     $response->getBody()->write("Message logged to logs/app.log");
//     return $response;
// });

$app->run();