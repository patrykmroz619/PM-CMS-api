<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Models\Content\ContentModel;
use Api\Models\Record\RecordModel;
use Api\Services\ContentModel\CreateContentModelService;
use Api\Services\ContentModel\UpdateContentModelService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ContentModelController
{
  private CreateContentModelService $createContentModelService;
  private UpdateContentModelService $updateContentModelService;
  private RecordModel $recordModel;
  private ContentModel $contentModel;

  public function __construct(
    CreateContentModelService $createContentModelService,
    UpdateContentModelService $updateContentModelService,
    RecordModel $recordModel,
    ContentModel $contentModel
  )
  {
    $this->createContentModelService = $createContentModelService;
    $this->updateContentModelService = $updateContentModelService;
    $this->recordModel = $recordModel;
    $this->contentModel = $contentModel;
  }

  public function createContentModel(Request $request, Response $response, string $projectId): Response
  {
    $body = $request->getParsedBody();

    $newContentModel = $this->createContentModelService->create($projectId, $body);

    $response->getBody()->write(json_encode($newContentModel));
    return $response->withStatus(201);
  }

  public function getContentModels(Request $request, Response $response, string $projectId): Response
  {
    $body = $request->getParsedBody();

    $contentModels = $this->contentModel->findByProjectIdAndUserId($projectId, $body['uid']);

    $response->getBody()->write(json_encode($contentModels));
    return $response;
  }

  public function updateContentModel(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $updatedModel = $this->updateContentModelService->update($contentModelId, $body);

    $response->getBody()->write(json_encode($updatedModel));
    return $response;
  }

  public function deleteContentModel(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $this->contentModel->deleteByIdAndUserId($contentModelId, $body['uid']);

    $this->recordModel->deleteManyByContentModelId($contentModelId);

    $response->getBody()->write(json_encode([]));
    return $response->withStatus(204);
  }
}
