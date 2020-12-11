<?php

declare(strict_types=1);

namespace Api\App;

use Slim\App;
use Api\Settings\Settings;
use Api\Helpers\ApiErrorHandler;
use Api\Middlewares\CorsMiddleware;
use Api\Middlewares\JSONBodyParserMiddleware;
use Api\Middlewares\SetContentTypeMiddleware;

return function (App $app) {
  $settings = Settings::getErrorMiddlewareConfig();
  $app->add(new CorsMiddleware());
  $app->add(new SetContentTypeMiddleware());
  $app->add(new JSONBodyParserMiddleware());

  $errorMiddleware = $app->addErrorMiddleware(
    $settings['displayErrorDetails'],
    $settings['logErrors'],
    $settings['logErrorDetails']
  );

  if($_ENV['MODE'] === 'PRODUCTION') {
    $errorHandler = new ApiErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
  }
};
