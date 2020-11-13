<?php

declare(strict_types=1);

use Slim\App;
use Middlewares\SetContentTypeMiddleware;
use Settings\Settings;
use Helpers\ApiErrorHandler;

return function (App $app) {
  $settings = Settings::getErrorMiddlewareConfig();

  $errorMiddleware = $app->addErrorMiddleware(
    $settings['displayErrorDetails'],
    $settings['logErrors'],
    $settings['logErrorDetails']
  );

  // $errorHandler = new ApiErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
  // $errorMiddleware->setDefaultErrorHandler($errorHandler);

  $app->add(new SetContentTypeMiddleware());
};
