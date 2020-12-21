<?php

declare(strict_types=1);

namespace Api\Models\ContentField;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldNotFoundException;
use Api\Models\ContentField\AbstractContentFieldModel;
use MongoDB\UpdateResult;

class ContentFieldModel extends AbstractContentFieldModel
{
  public function getFields(string $contentModelId): array
  {
    $filter = $this->getIdFilter($contentModelId);
    $contentModel = $this->findOne($filter);
    return (array) $contentModel['fields'];
  }

  public function addField(string $contentModelId, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($contentModelId);
    return $this->updateOne($filter, ['$push' => ['fields' => $data]]);
  }

  public function deleteField(string $contentModelId, string $fieldId): UpdateResult
  {
    $filter = $this->getIdFilter($contentModelId);
    return $this->updateOne($filter, ['$pull' => ['fields' => ['id' => $fieldId]]]);
  }

  public function updateField(string $contentModelId, string $fieldId, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($contentModelId);
    $filter['fields'] = ['id' => $fieldId];
    return $this->updateOne($filter, ['$set' => ['fields.$' => $data]]);
  }

  public function isFieldWithIdExist(string $contentModelId, string $fieldId): bool
  {
    $fields = $this->getFields($contentModelId);

    foreach($fields as $field) {
      if($field['id'] == $fieldId)
        return true;
    }

    throw new ContentFieldNotFoundException();
  }
}
