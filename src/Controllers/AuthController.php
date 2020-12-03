<?php

declare (strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\AuthService;
use Api\Services\TokenService;

class AuthController {
  private AuthService $authService;

  public function __construct(AuthService $authService)
  {
    $this->authService = $authService;
  }

  public function signIn(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $responseData = $this->authService->signIn($body);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function signUp(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $responseData = $this->authService->signUp($body);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function refreshToken(Request $request, Response $response): Response
  {
    $token = TokenService::getTokenFromRequest($request);

    $newTokens = $this->authService->refreshToken($token);

    $response->getBody()->write(json_encode($newTokens));
    return $response;
  }
}
