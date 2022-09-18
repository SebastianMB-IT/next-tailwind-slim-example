<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add cors
$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
          ->withHeader('Access-Control-Allow-Origin', '*');
});

// Register config
require __DIR__ . '/../app/config.php';
// Register lib
require __DIR__ . '/../app/lib.php';
// Register routes
require __DIR__ . '/../app/routes.php';

$app->run();
