<?php

declare(strict_types=1);

namespace Api\Models\Content;

use Api\Models\AbstractModel;

abstract class AbstractContentModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('content models');
  }
}
