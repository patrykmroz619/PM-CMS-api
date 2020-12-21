<?php

declare(strict_types=1);

namespace Api\Validators\ProjectData;

use Api\AppExceptions\ProjectExceptions\InvalidProjectNameException;
use Api\AppExceptions\ProjectExceptions\ProjectNameWasNotPassedException;
use Api\AppExceptions\ProjectExceptions\PublishedPropertyHasNotValueOfBooleanTypeException;
use Exception;

abstract class AbstractProjectDataValidator
{
  protected function userIdValidate(array $projectData): bool
  {
    if(!isset($projectData['uid']))
      throw new Exception('User id was not passed.');

    return true;
  }

  protected function projectNameValidate(array $projectData): bool
  {
    if(!isset($projectData['name']))
      throw new ProjectNameWasNotPassedException();

    if(strlen($projectData['name']) > 30)
      throw new InvalidProjectNameException();

    return true;
  }

  protected function publishedPropertyValidate(array $projectData): bool
  {
    if(!is_bool($projectData['published']))
      throw new PublishedPropertyHasNotValueOfBooleanTypeException();

    return true;
  }
}
