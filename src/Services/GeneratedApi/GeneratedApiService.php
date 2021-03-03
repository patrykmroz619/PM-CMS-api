<?php

declare(strict_types=1);

namespace Api\Services\GeneratedApi;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use Api\AppExceptions\RecordExceptions\RecordNotFoundException;
use Api\Models\Content\ContentModel;
use Api\Models\Record\RecordModel;
use Exception;

class GeneratedApiService
{
  private ContentModel $contentModel;
  private RecordModel $recordModel;

  public function __construct()
  {
    $this->contentModel = new ContentModel();
    $this->recordModel = new RecordModel();
  }

  public function getAllRecordsFromModel( string $endpoint, string $projectId ): array
  {
    $contentModel = $this->getContentModel($endpoint, $projectId);
    $records = $this->recordModel->getAll($contentModel['id']);

    for($i = 0; $i < count($records); $i++)
    {
      unset($records[$i]['contentModelId']);
      unset($records[$i]['userId']);
    }

    $responseData = [
      'contentModelName' => $contentModel['name'],
      'records' => $records
    ];

    return $responseData;
  }

  public function getOneRecord( string $endpoint, string $recordId, string $projectId): array
  {
    $contentModel = $this->getContentModel($endpoint, $projectId);

    try {
      $record = $this->recordModel->findById($recordId);
    } catch (Exception $e) {
      throw new RecordNotFoundException();
    }

    if(!$record || empty($record) || $record['contentModelId'] != $contentModel['id'])
      throw new RecordNotFoundException();

    unset($record['contentModelId']);
    unset($record['userId']);

    $responseData = [
      'contentModelName' => $contentModel['name'],
      'record' => $record
    ];

    return $responseData;
  }

  private function getContentModel(string $endpoint, string $projectId): array
  {
    $result = $this->contentModel->findByProjectIdAndEndpoint($projectId, $endpoint);

    if(empty($result))
      throw new ContentModelNotFoundException();

    return $result;
  }
}
