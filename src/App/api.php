<?php

declare(strict_types=1);

namespace Api\App;

use DI\Bridge\Slim\Bridge as App;
use Sentry;

if(getenv('MODE') === 'PRODUCTION') {
  Sentry\init(['dsn' => getenv('SENTRY_DNS') ]);
}

$app = App::create();

$middlewares = require 'middlewares.php';
$middlewares($app);

$routes = require 'routes.php';
$routes($app);

$app->run();
