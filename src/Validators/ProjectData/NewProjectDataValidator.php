<?php

declare(strict_types=1);

namespace Api\Validators\ProjectData;

use Api\Validators\ValidatorInterface;

class NewProjectDataValidator extends AbstractProjectDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->userIdValidate($data);
    $this->projectNameValidate($data);

    $correctProjectData = [
      'userId' => $data['uid'],
      'name' => $data['name'],
    ];

    return $correctProjectData;
  }
}
