<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class MainController {
  public function hello (Request $request, Response $response) {
    $response->getBody()->write('Hello');
    return $response;
  }
}
