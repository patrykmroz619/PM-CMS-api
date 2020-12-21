<?php

declare (strict_types=1);

namespace Api\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Api\AppExceptions\AuthExceptions\InvalidAccessTokenException;
use Api\Services\TokenService;

class AuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = TokenService::getTokenFromRequest($request);

    $tokenArray = (array) TokenService::validateToken($token);

    if(!empty($tokenArray) && $tokenArray['access'])
      return $handler->handle($this->applyUserIdFromTokenToParsedBody($request, $tokenArray));
    else
      throw new InvalidAccessTokenException();
  }

  private function applyUserIdFromTokenToParsedBody(Request $request, array $tokenArray): Request
  {
    $parsedBody = $request->getParsedBody();
    $bodyWithUid = array_merge($parsedBody ?? [], ['uid' => $tokenArray['uid']]);
    return $request->withParsedBody($bodyWithUid);
  }
}
