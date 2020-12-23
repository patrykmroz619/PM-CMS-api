<?php

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\DateFieldValidator;

class DateField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new DateFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
