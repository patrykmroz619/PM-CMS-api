<?php

declare (strict_types=1);

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Services\TokenService;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $authHeader = $request->getHeader('Authorization');
    $token = isset($authHeader[0]) ? substr($authHeader[0], 7) : null;

    $responseFactory = new ResponseFactory();
    $response = $responseFactory->createResponse();

    if($token) {
      $arrayToken = (array) TokenService::validateToken($token);

      if($arrayToken['active']) {
        return $response = $handler->handle($request);
      } else {
        $uid = $arrayToken['uid'];
        $newActiveToken = TokenService::getActiveToken($uid);
        $newRefreshToken = TokenService::getRefreshToken($uid);

        $response->getBody()->write(json_encode([
          'activeToken' => $newActiveToken,
          'refreshToken' => $newRefreshToken
        ]));

        return $response->withStatus(401);
      }

    } else {
      return $response->withStatus(401);
    }
  }
}
