<?php

declare (strict_types=1);

namespace Api\Helpers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler;
use Api\AppExceptions\AppException;

class ApiErrorHandler extends ErrorHandler {
  public const SERVER_ERROR = 'SERVER_ERROR';

  protected function respond(): Response
  {
    $exception = $this->exception;
    $statusCode = 500;
    $type = self::SERVER_ERROR;
    $description = 'An internal error has occurred while processing your request.';

    if ($exception instanceof AppException)
    {
      $statusCode = $exception->getCode();
      $description = $exception->getMessage();
      $type = $exception->getType();
    }

    $error = [
      'statusCode' => $statusCode,
      'error' => [
        'type' => $type,
        'description' => $description,
      ],
    ];

    $payload = json_encode($error, JSON_PRETTY_PRINT);

    $response = $this->responseFactory->createResponse($statusCode);
    $response->getBody()->write($payload);

    return $response;
  }
}
