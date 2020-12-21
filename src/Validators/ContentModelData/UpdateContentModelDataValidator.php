<?php

declare(strict_types=1);

namespace Api\Validators\ContentModelData;

use Api\Validators\ValidatorInterface;

class UpdateContentModelDataValidator extends AbstractContentModelDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $correctData = [];
    if(isset($data['name'])) {
      $this->validateName($data);
      $correctData['name'] = $data['name'];
    }

    if(isset($data['endpoint'])) {
      $this->validateEndpoint($data);
      $correctData['endpoint'] = $data['endpoint'];
    }

    return $correctData;
  }
}
