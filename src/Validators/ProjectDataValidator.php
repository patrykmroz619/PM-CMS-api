<?php

declare(strict_types=1);

namespace Api\Validators;

use Exception;
use Api\AppExceptions\ProjectExceptions\InvalidProjectNameException;
use Api\AppExceptions\ProjectExceptions\ProjectNameWasNotPassedException;
use Api\AppExceptions\ProjectExceptions\PublishedPropertyHasNotValueOfBooleanTypeException;

class ProjectDataValidator {
  public function validate($projectData) : array
  {
    $this->userIdValidate($projectData);
    $this->projectNameValidate($projectData);

    $correctProjectData = [
      'userId' => $projectData['uid'],
      'name' => $projectData['name'],
    ];

    return $correctProjectData;
  }

  public function updateValidate($projectData): array
  {
    $correctData = [];
    if(isset($projectData['name']))
    {
      $this->projectNameValidate($projectData);
      $correctData['name'] = $projectData['name'];
    }

    if(isset($projectData['published']))
    {
      $this->publishedPropertyValidate($projectData);
      $correctData['published'] = $projectData['published'];
    }

    return $correctData;
  }

  private function userIdValidate(array $projectData): bool
  {
    if(!isset($projectData['uid']))
      throw new Exception('User id was not passed.');

    return true;
  }

  private function projectNameValidate(array $projectData): bool
  {
    if(!isset($projectData['name']))
      throw new ProjectNameWasNotPassedException();

    if(strlen($projectData['name']) > 30)
      throw new InvalidProjectNameException();

    return true;
  }

  private function publishedPropertyValidate(array $projectData): bool
  {
    if(!is_bool($projectData['published']))
      throw new PublishedPropertyHasNotValueOfBooleanTypeException();

    return true;
  }
}
