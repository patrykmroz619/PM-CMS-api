<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\BooleanFieldValidator;

class BooleanField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new BooleanFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
