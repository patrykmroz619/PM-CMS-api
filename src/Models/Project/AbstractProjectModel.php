<?php

declare(strict_types=1);

namespace Api\Models\Project;

use Api\Models\AbstractModel;

abstract class AbstractProjectModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('projects');
  }
}
