<?php

declare (strict_types=1);

namespace Middlewares;

use AppExceptions\AuthExceptions\InvalidActiveTokenException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Services\TokenService;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = TokenService::getTokenFromRequest($request);

    $arrayToken = (array) TokenService::validateToken($token);

    if(!empty($arrayToken) && $arrayToken['active'])
      return $handler->handle($request);
    else
      throw new InvalidActiveTokenException();
  }
}
