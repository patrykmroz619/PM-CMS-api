<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\NumberFieldValidator;

class NumberField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new NumberFieldValidator();
    $this->fieldData = $validator->validate($data);
  }
}
