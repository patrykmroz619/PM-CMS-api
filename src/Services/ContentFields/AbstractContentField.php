<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Models\ContentModel;

abstract class AbstractContentField
{
  private ContentModel $contentModel;
  protected array $fieldData;

  public function __construct()
  {
    $this->contentModel = new ContentModel();
  }

  public function getName(): string
  {
    return $this->fieldData['name'];
  }

  public function getData(): array
  {
    return $this->fieldData;
  }

  protected function addFieldToContentModel(string $contentModelId): void
  {
    $this->contentModel->updateById($contentModelId, $this->fieldData);
  }
}
