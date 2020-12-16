<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldAlreadyExists;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldNotFoundException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeIsInvalidException;
use Api\Models\ContentModel;
use Api\Services\ContentFields\AbstractContentField;
use Api\Services\ContentFields\NumberField;
use Api\Services\ContentFields\TextField;

class ContentFieldService
{
  private SecurityService $securityService;
  private ContentModel $contentModel;

  public function __construct()
  {
    $this->securityService = new SecurityService();
    $this->contentModel = new ContentModel();
  }

  public function addFieldToContentModel(string $contentModelId, array $data): array
  {
    $newFieldData = $this->validateFieldToAdd($contentModelId, $data);

    $this->contentModel->addField($contentModelId, $newFieldData);

    return $newFieldData;
  }

  public function deleteFieldFromContentModel(string $contentModelId, array $data): void
  {
    $this->securityService->checkThatContentModelBelongToUser($contentModelId, $data['uid'], $this->contentModel);

    if(!isset($data['name']))
      throw new ContentFieldException('The name of content field was not passed.');

    $result = $this->contentModel->deleteField($contentModelId, $data['name']);

    if($result->getModifiedCount() == 0)
      throw new ContentFieldNotFoundException();
  }

  private function validateFieldToAdd(string $contentModelId, array $data): array
  {
    $this->securityService->
      checkThatContentModelBelongToUser($contentModelId, $data['uid'], $this->contentModel);

    $newField = $this->getFieldObject($data);

    $currentFields = $this->contentModel->getFields($contentModelId);

    foreach($currentFields as $currField) {
      if($currField['name'] === $newField->getName())
        throw new ContentFieldAlreadyExists();
    }

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
}
