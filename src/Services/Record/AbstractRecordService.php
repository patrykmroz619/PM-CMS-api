<?php

declare(strict_types=1);

namespace Api\Services\Record;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldNotFoundException;
use Api\AppExceptions\RecordExceptions\InvalidRecordException;
use Api\AppExceptions\RecordExceptions\RecordException;
use Api\Models\Content\ContentModel;
use Api\Models\Record\RecordModel;
use Api\Services\ContentFields\AbstractContentField;
use Api\Services\ContentFields\TextField;
use Api\Services\ContentFields\NumberField;
use Api\Services\ContentFields\BooleanField;
use Api\Services\ContentFields\DateField;
use Api\Services\ContentFields\ColorField;

abstract class AbstractRecordService
{
  protected ContentModel $contentModel;
  protected RecordModel $recordModel;

  public function __construct()
  {
    $this->contentModel = new ContentModel();
    $this->recordModel = new RecordModel();
  }

  protected function processRecordData(
    array $recordData,
    array $fieldsData,
    string $contentModelId,
    string $recordId = null
  ): array
  {
    $validatedRecord = [];

    foreach($fieldsData as $fieldData)
    {
      $correspondingRecordItem = $this->getCorrespondingRecordItem($recordData, (array) $fieldData);

      $validatedRecordItem = $this->validateRecordItem(
        $correspondingRecordItem,
        (array) $fieldData,
        $contentModelId,
        $recordId
      );

      array_push($validatedRecord, $validatedRecordItem);
    }

    return $validatedRecord;
  }

  protected function validateRecordItem(
    array $correspondingRecordItem,
    array $fieldData,
    string $contentModelId,
    string $recordId = null
  ): array
  {
    $this->doesRecordItemHaveValidStructure($correspondingRecordItem);

    $field = $this->getFieldObject((array) $fieldData);

    $validatedItem = $field->validateRecordItem($correspondingRecordItem);

    if($field->isUnique()) {
      $this->isRecordItemUnique($validatedItem, $contentModelId, $recordId);
    }

    return $validatedItem;
  }

  protected function getCorrespondingRecordItem(array $recordData, array $fieldData): array
  {
    $correspondingRecordItemIndex = array_search($fieldData['name'], array_column($recordData, 'name'));

    if($correspondingRecordItemIndex === false)
      throw new InvalidRecordException();

    return $recordData[$correspondingRecordItemIndex];
  }

  protected function getFieldObject(array $data): AbstractContentField
  {
    switch($data['type']) {
      case 'text':
        return new TextField($data);
      case 'number':
        return new NumberField($data);
      case 'boolean':
        return new BooleanField($data);
      case 'date':
        return new DateField($data);
      case 'color':
        return new ColorField($data);
      default:
        throw new ContentFieldNotFoundException();
    }
  }

  protected function doesRecordItemHaveValidStructure(array $recordItem): void
  {
    if(!isset($recordItem['name']) || !isset($recordItem['value']))
      throw new RecordException('One of record item is invalid');
  }

  protected function isRecordItemUnique(array $recordItem, string $contentModelId, string $recordId = null): void
  {
    $otherRecord = $this->recordModel->findByNameValueAndContentModelId(
      $recordItem['name'],
      $recordItem['value'],
      $contentModelId
    );

    if($otherRecord) {
      if($recordId && $recordId == $otherRecord['id'])
        return;

        $recordName = $recordItem['name'];
        throw new RecordException("The $recordName is not unique");
    }
  }
}
