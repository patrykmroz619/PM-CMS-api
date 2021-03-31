<?php

declare(strict_types=1);

namespace Api\Models\Record;

use Api\Models\AbstractModel;

abstract class AbstractRecordModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('records');
  }
}
