<?php

declare(strict_types=1);

namespace Api\Validators\ContentModelData;

use Api\Validators\ValidatorInterface;

class NewContentModelDataValidator extends AbstractContentModelDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->validateName($data);
    $this->validateEndpoint($data);

    $correctData = [
      'name' => $data['name'],
      'endpoint' => $data['endpoint']
    ];

    return $correctData;
  }
}
