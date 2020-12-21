<?php

declare(strict_types=1);

namespace Api\Models\ContentField;

use Api\Models\AbstractModel;

abstract class AbstractContentFieldModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('content models');
  }
}
