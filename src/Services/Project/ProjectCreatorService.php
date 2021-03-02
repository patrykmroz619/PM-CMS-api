<?php

declare(strict_types=1);

namespace Api\Services\Project;

use Api\AppExceptions\ProjectExceptions\ProjectAlreadyExistsException;
use Api\Models\Project\ProjectModel;
use Api\Validators\ProjectData\NewProjectDataValidator;

class ProjectCreatorService
{
  private ProjectModel $projectModel;
  private NewProjectDataValidator $validator;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
    $this->validator = new NewProjectDataValidator();
  }

  public function create(array $data): array
  {
    $projectData = $this->processData($data);

    $newProjectId = $this->projectModel->create($projectData);

    $projectData['id'] = $newProjectId;
    return $projectData;
  }

  private function processData(array $data): array
  {
    $projectData = $this->validate($data);

    $currentTime = time();
    $projectData['createdAt'] = $currentTime;
    $projectData['published'] = true;

    return $projectData;
  }

  private function validate(array $data): array
  {
    $projectData = $this->validator->validate($data);

    $project = $this->projectModel->findByUserIdAndProjectName($projectData['userId'], $projectData['name']);

    if(!!$project)
      throw new ProjectAlreadyExistsException();

    return $projectData;
  }
}
