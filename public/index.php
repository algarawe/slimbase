<?php

define('APP_START_TIME', hrtime(true));
define('ENVIRONMENT', 'development');

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use SlimBase\Monitoring\ShutdownMonitor;
use SlimBase\Middleware\TimingMiddleware;







// Define the base path of the project (one level up from public)
define('APP_ROOT', __DIR__);
// Go up TWO levels: out of public/, out of slimbase/, into vendor/
require __DIR__ . '/../../vendor/autoload.php';



/*Initializing App*/
//$appConfig = require_once '/../src/config/' . ENVIRONMENT . '.php';
//$app = new \Slim\App(['settings' =>  $appConfig]);

// 1. Initialize ContainerBuilder
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../src/config/' . ENVIRONMENT . '.php');

// 2. Load your definitions from the config folder
$containerBuilder->addDefinitions(__DIR__ . '/../src/config/container.php');

// 3. Build the Container and give it to Slim
$container = $containerBuilder->build();
AppFactory::setContainer($container);
$app = AppFactory::create();


//ShutdownMonitor::register();
ShutdownMonitor::init($container->get(LoggerInterface::class));

$app->add(new TimingMiddleware());

 // Tell Slim the sub-directory it is running in
$app->setBasePath('/slimbase');
 
//$app->addErrorMiddleware(true, true, true, $logger);
$app->addErrorMiddleware(true, true, true, $container->get(LoggerInterface::class));
// 4. Use the Logger in a Route

// 2. Register Routes
//$routes = require __DIR__ . '/routes/route.php';
$routes = require __DIR__ . '/../src/routes/route.php';
$routes($app);

$app->run();