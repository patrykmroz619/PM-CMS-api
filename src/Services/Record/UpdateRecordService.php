<?php

declare(strict_types=1);

namespace Api\Services\Record;

use Api\AppExceptions\RecordExceptions\RecordNotFoundException;
use Api\AppExceptions\RecordExceptions\RecordNotPassedException;

class UpdateRecordService extends AbstractRecordService
{
  public function updateRecord(string $recordId, array $requestData): array
  {
    if(!isset($requestData['record']))
      throw new RecordNotPassedException();

    $record = $this->recordModel->findById($recordId);

    if(!$record)
      throw new RecordNotFoundException();

    $contentModel = $this->contentModel->findByIdAndUserId($record['contentModelId'], $requestData['uid']);
    $fields = (array) $contentModel['fields'];

    $updatedRecord = $this->processRecordData($requestData['record'], $fields, $contentModel['id'], $recordId);

    $result = $this->recordModel->updateRecord($recordId, $updatedRecord);

    if($result->getMatchedCount() == 0)
      throw new RecordNotFoundException();

    $record['data'] = $updatedRecord;

    return $record;
  }
}
