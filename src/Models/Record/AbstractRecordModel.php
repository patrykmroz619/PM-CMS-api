<?php

declare(strict_types=1);

namespace Api\Models\Record;

use Api\Models\AbstractModel;
use MongoDB\InsertOneResult;

abstract class AbstractRecordModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('records');
  }
}
