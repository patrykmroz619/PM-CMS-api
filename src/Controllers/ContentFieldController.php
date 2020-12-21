<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\ContentModel\ContentFieldService;

class ContentFieldController
{
  private ContentFieldService $contentFieldService;

  public function __construct(ContentFieldService $contentFieldService)
  {
    $this->contentFieldService = $contentFieldService;
  }

  public function addField(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $newfield = $this->contentFieldService->addFieldToContentModel($contentModelId, $body);

    $response->getBody()->write(json_encode($newfield));
    return $response->withStatus(201);
  }
  public function updateField(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $updatedField = $this->contentFieldService->updateField($contentModelId, $body);

    $response->getBody()->write(json_encode($updatedField));
    return $response;
  }

  public function deleteField(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $this->contentFieldService->deleteFieldFromContentModel($contentModelId, $body);

    return $response->withStatus(204);
  }
}
