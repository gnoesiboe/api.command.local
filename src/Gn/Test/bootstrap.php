<?php

error_reporting(E_ALL & (~E_STRICT));

use Symfony\Component\ClassLoader\ClassLoader;

require_once dirname(__FILE__) . '/../../../vendor/autoload.php';

$autoloader = new ClassLoader();
$autoloader->addPrefixes(array(
    'Gn' => dirname(__FILE__) . '/../../'
));
$autoloader->register();

