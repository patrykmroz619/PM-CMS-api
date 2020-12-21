<?php

declare (strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\Auth\RefreshTokenService;
use Api\Services\Auth\SignInService;
use Api\Services\Auth\SignUpService;
use Api\Services\TokenService;

class AuthController {
  private SignUpService $signUpService;
  private SignInService $signInService;
  private RefreshTokenService $refreshTokenService;

  public function __construct(
    SignUpService $signUpService,
    SignInService $signInService,
    RefreshTokenService $refreshTokenService
  )
  {
    $this->signUpService = $signUpService;
    $this->signInService = $signInService;
    $this->refreshTokenService = $refreshTokenService;
  }

  public function signIn(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $responseData = $this->signInService->signIn($body);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function signUp(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $responseData = $this->signUpService->signUp($body);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function refreshToken(Request $request, Response $response): Response
  {
    $token = TokenService::getTokenFromRequest($request);

    $newTokens = $this->refreshTokenService->refreshToken($token);

    $response->getBody()->write(json_encode($newTokens));
    return $response;
  }
}
