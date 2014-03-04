<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use App\ContainerFactory;
use Gn\Api\RequestHandler;
use Symfony\Component\ClassLoader\ClassLoader;
use Gn\Api\ServiceLocator\RequestHandlerServiceLocator;

$autoloader = new ClassLoader();
$autoloader->addPrefixes(array(
    'App' => dirname(__FILE__) . '/../src/',
    'Gn' => dirname(__FILE__) . '/../src/'
));
$autoloader->register();

$diContainer = ContainerFactory::create()->generateContainer();

//@todo possibility to use other response adapters for JSON/XML etc. => accept headers
$response = RequestHandler::create(new RequestHandlerServiceLocator($diContainer))->execute();
$response->send();

exit(0);
