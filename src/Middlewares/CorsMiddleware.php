<?php

declare (strict_types=1);

namespace Api\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Api\Settings\Settings;
use Slim\Routing\RouteContext;

class CorsMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $routeContext = RouteContext::fromRequest($request);
    $routingResults = $routeContext->getRoutingResults();
    $methods = $routingResults->getAllowedMethods();

    $response = $handler->handle($request);

    $urls = Settings::getAppsUrl();

    $response = $response->withHeader('Access-Control-Allow-Origin', $urls['client']);
    $response = $response->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, sentry-trace');
    $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));

    return $response;
  }
}
