<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Models\Content\ContentModel;

abstract class AbstractContentField
{
  protected array $fieldData;

  public function getName(): string
  {
    return $this->fieldData['name'];
  }

  public function getId(): string
  {
    return $this->fieldData['id'];
  }

  public function getData(): array
  {
    return $this->fieldData;
  }

  public function isUnique(): bool
  {
    if(isset($this->fieldData['unique'])) {
      return boolval($this->fieldData['unique']);
    }

    return false;
  }

  abstract public function validateRecordItem(array $recordItem): array;
}
