<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ProjectExceptions\ProjectAlreadyExistsException;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\AppExceptions\ProjectExceptions\EndpointIsNotUniqueException;
use Api\AppExceptions\ProjectExceptions\ProjectNameIsNotUniqueException;
use Api\Models\ProjectModel;
use Api\Models\UserModel;
use Api\Validators\ProjectDataValidator;

class ProjectService {
  private ProjectModel $projectModel;
  private ProjectDataValidator $projectDataValidator;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
    $this->userModel = new UserModel();
    $this->projectDataValidator = new ProjectDataValidator();
  }

  public function addProject($data)
  {
    $projectData = $this->processData($data);

    $result = $this->projectModel->insertOne($projectData);

    $newProjectId = $result->getInsertedId()->__toString();
    $projectData['id'] = $newProjectId;

    return $projectData;
  }

  public function getOneProject(string $id): array
  {
    $project = $this->projectModel->findOneById($id);

    if(empty($project))
      throw new ProjectNotFoundException();

    return (array) $project;
  }

  public function getProjects(string $uid): array
  {
    $projectsList = $this->projectModel->findManyByUserId($uid);

    return $projectsList;
  }

  public function updateProject(string $id, array $data): array
  {
    $updateData = $this->projectDataValidator->updateValidate($data);
    $updateData['updatedAt'] = time();

    if(isset($updateData['name'])) {
      $this->checkThatProjectNameIsUnique($data['uid'], $updateData['name'], $id);
    }

    if(isset($updateData['endpoint'])) {
      $this->checkThatEndpointIsUnique($data['uid'], $updateData['endpoint'], $id);
    }

    $this->projectModel->updateById($id, $updateData);
    $updatedProject = $this->projectModel->findOneById($id);

    if(empty($updatedProject))
      throw new ProjectNotFoundException();

    return $updatedProject;
  }

  public function deleteProject(string $id): void
  {
    $result = $this->projectModel->deleteOne($id);
    if($result->getDeletedCount() == 0)
      throw new ProjectNotFoundException();
  }

  private function processData(array $data): array
  {
    $projectData = $this->validate($data);

    if($projectData['endpoint'] === null) {
      $projectData['endpoint'] = $this->createSlug($projectData['name']);
    }

    $currentTime = time();
    $projectData['createdAt'] = $currentTime;
    $projectData['updatedAt'] = $currentTime;
    $projectData['published'] = true;

    return $projectData;
  }

  private function validate(array $data): array
  {
    $projectData = $this->projectDataValidator->validate($data);

    $project = $this->projectModel->findOneByUidAndName($projectData['userId'], $projectData['name']);
    if(!!$project)
      throw new ProjectAlreadyExistsException();

    $this->checkThatEndpointIsUnique($projectData['userId'], $projectData['endpoint']);

    return $projectData;
  }

  private function checkThatProjectNameIsUnique( string $userId, string $name, string $id): bool
  {
    $result = $this->projectModel->findMany(
      ['userId' => $userId, 'name' => $name]
    );

    foreach($result as $project)
    {
      if($project['name'] === $name && $project['id'] != $id)
        throw new ProjectNameIsNotUniqueException();
    }

    return true;
  }

  private function checkThatEndpointIsUnique( string $userId, string $endpoint, string $id = null): bool
  {
    $result = $this->projectModel->findMany(
      ['userId' => $userId, 'endpoint' => $endpoint]
    );

    foreach($result as $project)
    {
      if($id) {
        if($project['endpoint'] === $endpoint && $project['id'] != $id)
          throw new EndpointIsNotUniqueException();
      } else {
        if($project['endpoint'] === $endpoint)
          throw new EndpointIsNotUniqueException();
      }
    }

    return true;
  }

  private function createSlug(string $text): string
  {
    $pattern = '/[^A-Za-z0-9-]+/';

    $slug = preg_replace($pattern, '-', $text);
    return $slug;
  }
}
