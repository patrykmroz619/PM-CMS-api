<?php

namespace Api\Helpers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PreflightAction
{
  public function __invoke(Request $request,Response $response): Response {
    return $response;
  }
}
