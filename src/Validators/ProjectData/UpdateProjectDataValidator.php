<?php

declare(strict_types=1);

namespace Api\Validators\ProjectData;

use Api\Validators\ValidatorInterface;

class UpdateProjectDataValidator extends AbstractProjectDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $correctData = [];
    if(isset($data['name']))
    {
      $this->projectNameValidate($data);
      $correctData['name'] = $data['name'];
    }

    if(isset($data['published']))
    {
      $this->publishedPropertyValidate($data);
      $correctData['published'] = $data['published'];
    }

    return $correctData;
  }
}
