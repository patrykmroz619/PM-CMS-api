<?php

declare(strict_types=1);

namespace Api\Validators;

use Exception;
use Api\AppExceptions\ProjectExceptions\InvalidApiEndpointForProjectException;
use Api\AppExceptions\ProjectExceptions\InvalidProjectNameException;
use Api\AppExceptions\ProjectExceptions\ProjectNameWasNotPassedException;
use Api\AppExceptions\ProjectExceptions\PublishedPropertyHasNotValueOfBooleanTypeException;

class ProjectDataValidator {
  public function validate($projectData) : array
  {
    $this->userIdValidate($projectData);
    $this->projectNameValidate($projectData);
    $this->apiEndpointValidate($projectData);

    $correctProjectData = [
      'userId' => $projectData['uid'],
      'name' => $projectData['name'],
      'endpoint' => $projectData['endpoint'] ?? null
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

    if(isset($projectData['endpoint']))
    {
      $this->apiEndpointValidate($projectData);
      $correctData['endpoint'] = $projectData['endpoint'];
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

  private function apiEndpointValidate(array $projectData): bool
  {
    if(isset($projectData['endpoint']))
    {
      $pattern = "/^[a-z0-9]+(?:-[a-z0-9]+)*$/";
      if(!preg_match($pattern, $projectData['endpoint']))
        throw new InvalidApiEndpointForProjectException();
    }

    return true;
  }

  private function publishedPropertyValidate(array $projectData): bool
  {
    if(!is_bool($projectData['published']))
      throw new PublishedPropertyHasNotValueOfBooleanTypeException();

    return true;
  }
}
