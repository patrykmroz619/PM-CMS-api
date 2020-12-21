<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;


abstract class AbstractContentField
{
  protected array $fieldData;

  public function getName(): string
  {
    return $this->fieldData['name'];
  }

  public function getData(): array
  {
    return $this->fieldData;
  }
}
