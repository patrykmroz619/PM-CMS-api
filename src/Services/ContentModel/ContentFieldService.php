<?php

declare(strict_types=1);

namespace Api\Services\ContentModel;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldAlreadyExists;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldNotFoundException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeIsInvalidException;
use Api\AppExceptions\ContentFieldExceptions\NameOfContentFieldNotPassedException;
use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use Api\Models\Content\ContentModel;
use Api\Models\ContentField\ContentFieldModel;
use Api\Services\ContentFields\AbstractContentField;
use Api\Services\ContentFields\NumberField;
use Api\Services\ContentFields\TextField;

class ContentFieldService
{
  private ContentModel $contentModel;
  private ContentFieldModel $contentFieldModel;

  public function __construct()
  {
    $this->contentModel = new ContentModel;
    $this->contentFieldModel = new ContentFieldModel();
  }

  public function addFieldToContentModel(string $contentModelId, array $data): array
  {
    $newFieldData = $this->validateFieldToAdd($contentModelId, $data);

    $this->contentFieldModel->addField($contentModelId, $newFieldData);

    return $newFieldData;
  }

  public function deleteFieldFromContentModel(string $contentModelId, array $data): void
  {
    $this->isContentModelBelongToUser($contentModelId, $data['uid']);

    if(!isset($data['name']))
      throw new NameOfContentFieldNotPassedException();

    $result = $this->contentFieldModel->deleteField($contentModelId, $data['name']);

    if($result->getModifiedCount() == 0)
      throw new ContentFieldNotFoundException();
  }

  private function validateFieldToAdd(string $contentModelId, array $data): array
  {
    $this->isContentModelBelongToUser($contentModelId, $data['uid']);

    $newField = $this->getFieldObject($data);

    $this->isFieldNameUnique($newField, $contentModelId);

    return $newField->getData();
  }

  private function getFieldObject(array $data): AbstractContentField
  {
    switch($data['type']) {
      case 'text':
        return new TextField($data);
      case 'number':
        return new NumberField($data);
      default:
        throw new ContentFieldTypeIsInvalidException();
    }
  }

  private function isFieldNameUnique(AbstractContentField $field, string $contentModelId): void
  {
    $currentFields = $this->contentFieldModel->getFields($contentModelId);

    $name = $field->getName();

    foreach($currentFields as $currField) {
      if($currField['name'] === $name)
        throw new ContentFieldAlreadyExists();
    }
  }

  private function isContentModelBelongToUser(string $contentModelId, string $userId): void
  {
    $result = $this->contentModel->findByIdAndUserId($contentModelId, $userId);

    if(!$result)
      throw new ContentModelNotFoundException();
  }
}
