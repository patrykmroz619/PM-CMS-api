<?php

declare(strict_types=1);

use Slim\App;
use Settings\Settings;
use Helpers\ApiErrorHandler;
use Middlewares\CorsMiddleware;
use Middlewares\JSONBodyParserMiddleware;
use Middlewares\SetContentTypeMiddleware;

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

  $errorHandler = new ApiErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
  $errorMiddleware->setDefaultErrorHandler($errorHandler);
};
