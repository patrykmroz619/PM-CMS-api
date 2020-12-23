<?php

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\DateFieldValidator;
use Api\Validators\FieldDataValidators\MediaFieldValidator;

class MediaField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new MediaFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
