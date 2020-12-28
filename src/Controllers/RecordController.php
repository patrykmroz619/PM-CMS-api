<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Models\Record\RecordModel;
use Api\Services\Record\AddRecordService;
use Api\Services\Record\UpdateRecordService;
use Api\Services\RecordService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RecordController
{
  private AddRecordService $addRecordService;
  private UpdateRecordService $updateRecordService;
  private RecordModel $recordModel;

  public function __construct(
    AddRecordService $addRecordService,
    UpdateRecordService $updateRecordService,
    RecordModel $recordModel
  )
  {
    $this->addRecordService = $addRecordService;
    $this->updateRecordService = $updateRecordService;
    $this->recordModel = $recordModel;
  }

  public function addRecord(Request $request, Response $response, string $contentModelId): Response
  {
    $body = $request->getParsedBody();

    $responseData = $this->addRecordService->addRecord($contentModelId, $body);

    $response->getBody()->write(json_encode($responseData));
    return $response->withStatus(201);
  }

  public function getRecords(Request $request, Response $response, string $contentModelId): Response
  {
    $records = $this->recordModel->getAll($contentModelId);

    $response->getBody()->write(json_encode(['records' => $records]));
    return $response;
  }

  public function updateRecord(Request $request, Response $response, string $recordId): Response
  {
    $body = $request->getParsedBody();

    $updatedRecord = $this->updateRecordService->updateRecord($recordId, $body);

    $response->getBody()->write(json_encode($updatedRecord));
    return $response;
  }

  public function deleteRecord(Request $request, Response $response, string $recordId): Response
  {
    $body = $request->getParsedBody();

    $this->recordModel->deleteByIdAndUserId($recordId, $body['uid']);

    return $response->withStatus(204);
  }
}
