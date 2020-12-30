<?php

namespace Api\Services\ContentFields;

use Api\Validators\FieldDataValidators\MediaFieldValidator;

class MediaField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new MediaFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }
}
