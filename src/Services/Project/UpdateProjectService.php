<?php

declare(strict_types=1);

namespace Api\Services\Project;

use Api\AppExceptions\ProjectExceptions\ProjectNameIsNotUniqueException;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\Models\Project\ProjectModel;
use Api\Services\SecurityService;
use Api\Validators\ProjectData\UpdateProjectDataValidator;

class UpdateProjectService
{
  private ProjectModel $projectModel;
  private UpdateProjectDataValidator $validator;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
    $this->validator = new UpdateProjectDataValidator();
  }

  public function update(string $id, array $data): array
  {
    $updatedData = $this->validate($id, $data);

    $this->projectModel->updateById($id, $updatedData);
    $updatedProject = $this->projectModel->findById($id);

    if(empty($updatedProject))
      throw new ProjectNotFoundException();

    return $updatedProject;
  }

  private function validate(string $id, array $data): array
  {
    $updateData = $this->validator->validate($data);
    $updateData['updatedAt'] = time();

    if(isset($updateData['name'])) {
      $this->checkThatProjectNameIsUnique($data['uid'], $updateData['name'], $id);
    }

    return $updateData;
  }

  private function checkThatProjectNameIsUnique( string $userId, string $name, string $id): bool
  {
    $projects = $this->projectModel->findByUserId($userId);

    foreach($projects as $project)
    {
      if($project['name'] === $name && $project['id'] != $id)
        throw new ProjectNameIsNotUniqueException();
    }

    return true;
  }
}
