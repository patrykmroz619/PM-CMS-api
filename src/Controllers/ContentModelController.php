<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\ContentModelService;
use Psr\Http\Message\ServerRequestInterface;

class ContentModelController
{
  private ContentModelService $contentModelService;

  public function __construct(ContentModelService $contentModelService)
  {
    $this->contentModelService = $contentModelService;
  }

  public function createContentModel(Request $request, Response $response, string $projectId): Response
  {
    $requestData = $request->getParsedBody();

    $requestData['projectId'] = $projectId;

    $newContentModel = $this->contentModelService->create($requestData);

    $response->getBody()->write(json_encode($newContentModel));
    return $response->withStatus(201);
  }

  public function getContentModels(Request $request, Response $response, string $projectId): Response
  {
    $body = $request->getParsedBody();

    $contentModels = $this->contentModelService->getContentModels($projectId, $body['uid']);

    $response->getBody()->write(json_encode($contentModels));
    return $response;
  }

  public function updateContentModel(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $updatedModel = $this->contentModelService->updateContentModel($contentModelId, $body);

    $response->getBody()->write(json_encode($updatedModel));
    return $response;
  }

  public function deleteContentModel(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $this->contentModelService->delete($contentModelId, $body['uid']);

    $response->getBody()->write(json_encode([]));
    return $response->withStatus(204);
  }
}
