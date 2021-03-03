<?php

declare(strict_types=1);

namespace Api\Services\Project;

use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\Models\Project\ProjectModel;
use Api\Services\Token\PublicApiTokenService;
use Exception;

class ProjectApiKeyService
{
  private ProjectModel $projectModel;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
  }

  public function generateApiKey(string $projectId, string $userId): string
  {
    $key = PublicApiTokenService::generateToken($projectId, $userId);

    $this->validate($projectId, $userId);

    $this->projectModel->updateById($projectId, ['apiKey' => $key]);

    return $key;
  }

  private function validate(string $projectId, string $userId): void
  {
    try
    {
      $project = $this->projectModel->findById($projectId);

      if($project['userId'] !== $userId)
        throw new Exception();
    }
    catch (Exception $e)
    {
      throw new ProjectNotFoundException();
    }

  }
}
