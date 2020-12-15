<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ProjectExceptions\ProjectAlreadyExistsException;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\AppExceptions\ProjectExceptions\ProjectNameIsNotUniqueException;
use Api\Models\ProjectModel;
use Api\Models\UserModel;
use Api\Validators\ProjectDataValidator;

class ProjectService {
  private ProjectModel $projectModel;
  private ProjectDataValidator $projectDataValidator;
  private SecurityService $securityService;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
    $this->userModel = new UserModel();
    $this->projectDataValidator = new ProjectDataValidator();
    $this->securityService = new SecurityService();
  }

  public function addProject($data)
  {
    $projectData = $this->processData($data);

    $result = $this->projectModel->insertOne($projectData);

    $newProjectId = $result->getInsertedId()->__toString();
    $projectData['id'] = $newProjectId;

    return $projectData;
  }

  public function getOneProject(string $id, string $userId): array
  {
    $project = $this->projectModel->findOneById($id);

    if($project['userId'] != $userId)
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
    $this->securityService->checkThatProjectBelongToUser($id, $data['uid'], $this->projectModel);

    $updateData = $this->projectDataValidator->updateValidate($data);
    $updateData['updatedAt'] = time();

    if(isset($updateData['name'])) {
      $this->checkThatProjectNameIsUnique($data['uid'], $updateData['name'], $id);
    }

    $this->projectModel->updateById($id, $updateData);
    $updatedProject = $this->projectModel->findOneById($id);

    if(empty($updatedProject))
      throw new ProjectNotFoundException();

    return $updatedProject;
  }

  public function deleteProject(string $id, string $userId): void
  {
    $this->securityService->checkThatProjectBelongToUser($id, $userId, $this->projectModel);

    $result = $this->projectModel->deleteOne($id);
    if($result->getDeletedCount() == 0)
      throw new ProjectNotFoundException();
  }

  private function processData(array $data): array
  {
    $projectData = $this->validate($data);

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
}
