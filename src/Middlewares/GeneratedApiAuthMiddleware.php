<?php

declare (strict_types=1);

namespace Api\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Api\AppExceptions\GeneratedApiExceptions\AccessDeniedException;
use Api\Services\Token\GeneratedApiTokenService;

class GeneratedApiAuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = GeneratedApiTokenService::getTokenFromRequest($request);

    $tokenArray = (array) GeneratedApiTokenService::validateToken($token);

    if(!empty($tokenArray) && isset($tokenArray['apiKey']))
      return $handler->handle($this->applyDataFromTokenToRequestBody($request, $tokenArray));
    else
      throw new AccessDeniedException();
  }

  private function applyDataFromTokenToRequestBody(Request $request, array $tokenArray): Request
  {
    $parsedBody = $request->getParsedBody();
    $tokenData = ['projectId' => $tokenArray['projectId'], 'userId' => $tokenArray['userId']];
    $requestBody = array_merge($parsedBody ?? [], $tokenData);
    return $request->withParsedBody($requestBody);
  }
}
