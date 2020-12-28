<?php

declare(strict_types=1);

namespace Api\Services\Record;

use Api\AppExceptions\RecordExceptions\RecordNotPassedException;

class AddRecordService extends AbstractRecordService
{
  public function addRecord(string $contentModelId, array $requestData): array
  {
    if(!isset($requestData['record']))
      throw new RecordNotPassedException();

    $contentModel = $this->contentModel->findByIdAndUserId($contentModelId, $requestData['uid']);
    $fields = (array) $contentModel['fields'];

    $newRecord = $this->processRecordData($requestData['record'], $fields, $contentModelId);

    $dataToSave = [
      'userId' => $requestData['uid'],
      'contentModelId' => $contentModelId,
      'record' => $newRecord
    ];

    $this->recordModel->add($dataToSave);

    return $dataToSave;
  }
}
