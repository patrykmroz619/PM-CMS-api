<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\UserService;
use Api\Services\TokenService;

class UserController {
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getActiveUser(Request $request, Response $response): Response
  {
    $token = TokenService::getTokenFromRequest($request);

    $responseData = $this->userService->getUserWithUidFromToken($token);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }
}
