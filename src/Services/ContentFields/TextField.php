<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\TextFieldValidator;

class TextField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new TextFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
