<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\ColorFieldValidator;

class ColorField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new ColorFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
