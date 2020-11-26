<?php

declare (strict_types=1);

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class CorsMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    if($request->getMethod() !== 'OPTIONS') {
      $response = $handler->handle($request);
    } else {
      $responseFactory = new ResponseFactory();
      $response = $responseFactory->createResponse();
      $response->withStatus(200);
    }

    return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
  }
}
