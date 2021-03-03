<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Services\GeneratedApi\GeneratedApiService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GeneratedApiController
{
  private GeneratedApiService $generatedApiService;

  public function __construct(GeneratedApiService $generatedApiService)
  {
    $this->generatedApiService = $generatedApiService;
  }

  public function list(
    Request $request,
    Response $response,
    string $endpoint
  ): Response
  {
    $parsedBody = $request->getParsedBody();

    $responseData = $this->generatedApiService
      ->getAllRecordsFromModel($endpoint, $parsedBody['projectId']);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function get(
    Request $request,
    Response $response,
    string $endpoint,
    string $recordId
  ): Response
  {
    $parsedBody = $request->getParsedBody();

    $responseData = $this->generatedApiService
      ->getOneRecord($endpoint, $recordId, $parsedBody['projectId']);

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }
}
