<?php

declare (strict_types=1);

namespace Middlewares;

use Models\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Services\TokenService;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $authHeader = $request->getHeader('Authorization');
    $token = isset($authHeader[0]) ? substr($authHeader[0], 7) : '';

    $responseFactory = new ResponseFactory();
    $response = $responseFactory->createResponse();
    $arrayToken = (array) TokenService::validateToken($token);

    if(!empty($arrayToken) && $arrayToken['active'])
      return $response = $handler->handle($request);
    else
      return $response->withStatus(401);
  }
}
