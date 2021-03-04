<?php

declare(strict_types=1);

namespace Api\Services\ContentModel;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldAlreadyExists;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldNotFoundException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeIsInvalidException;
use Api\AppExceptions\ContentFieldExceptions\IdOfContentFieldNotPassedException;
use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use Api\Models\Content\ContentModel;
use Api\Models\ContentField\ContentFieldModel;
use Api\Services\ContentFields\AbstractContentField;
use Api\Services\ContentFields\BooleanField;
use Api\Services\ContentFields\ColorField;
use Api\Services\ContentFields\DateField;
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
    $data['id'] = uniqid();

    $newFieldData = $this->validateField($contentModelId, $data);

    $this->contentFieldModel->addField($contentModelId, $newFieldData);

    return $newFieldData;
  }

  public function updateField(string $contentModelId, array $data): array
  {
    $this->contentFieldModel->isFieldWithIdExist($contentModelId, $data['id']);

    $updateFieldData = $this->validateField($contentModelId, $data, true);

    $this->contentFieldModel->updateField($contentModelId, $updateFieldData['id'], $updateFieldData);

    return $updateFieldData;
  }

  public function deleteFieldFromContentModel(string $contentModelId, array $data): void
  {
    $this->isContentModelBelongToUser($contentModelId, $data['uid']);

    if(!isset($data['id']))
      throw new IdOfContentFieldNotPassedException();

    $result = $this->contentFieldModel->deleteField($contentModelId, $data['id']);

    if($result->getModifiedCount() == 0)
      throw new ContentFieldNotFoundException();
  }

  private function validateField(string $contentModelId, array $data, bool $update = false): array
  {
    if(!isset($data['id']))
      throw new IdOfContentFieldNotPassedException();

    $this->isContentModelBelongToUser($contentModelId, $data['uid']);

    $newField = $this->getFieldObject($data);

    $this->isFieldNameUnique($newField, $contentModelId, $update);

    return $newField->getData();
  }

  private function getFieldObject(array $data): AbstractContentField
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
        throw new ContentFieldTypeIsInvalidException();
    }
  }

  private function isFieldNameUnique(AbstractContentField $field, string $contentModelId, bool $update): void
  {
    $currentFields = $this->contentFieldModel->getFields($contentModelId);

    $name = $field->getName();
    $id = $field->getId();

    foreach($currentFields as $currField) {
      if($update) {
        if($currField['name'] == $name && $currField['id'] != $id)
          throw new ContentFieldAlreadyExists();
      } else {
        if($currField['name'] == $name)
          throw new ContentFieldAlreadyExists();
      }
    }
  }

  private function isContentModelBelongToUser(string $contentModelId, string $userId): void
  {
    $result = $this->contentModel->findByIdAndUserId($contentModelId, $userId);

    if(!$result)
      throw new ContentModelNotFoundException();
  }
}
