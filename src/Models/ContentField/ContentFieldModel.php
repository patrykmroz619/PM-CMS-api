<?php

declare(strict_types=1);

namespace Api\Models\ContentField;

use Api\Models\ContentField\AbstractContentFieldModel;
use MongoDB\UpdateResult;

class ContentFieldModel extends AbstractContentFieldModel
{
  public function getFields(string $id): array
  {
    $filter = $this->getIdFilter($id);
    $contentModel = $this->findOne($filter);
    return (array) $contentModel['fields'];
  }

  public function addField(string $id, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($id);
    return $this->updateOne($filter, ['$push' => ['fields' => $data]]);
  }

  public function deleteField(string $id, string $fieldName): UpdateResult
  {
    $filter = $this->getIdFilter($id);
    return $this->updateOne($filter, ['$pull' => ['fields' => ['name' => $fieldName]]]);
  }

  public function updateFields(string $id, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($id);
    return $this->updateOne($filter, ['$set' => ['fields' => $data]]);
  }
}
