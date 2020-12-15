<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFound;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\Models\ContentModel;
use Api\Models\ProjectModel;

class SecurityService
{
  public function checkThatProjectBelongToUser(string $projectId, string $userId, ProjectModel $projectModel): void
  {
    $result = $projectModel->findOneById($projectId);

    if(empty($result) || $result['userId'] != $userId)
      throw new ProjectNotFoundException();
  }

  public function checkThatContentModelBelongToUser(
    string $contentModelId,
    string $userId,
    ContentModel $contentModel
  ): void
  {
    $result = $contentModel->findOneById($contentModelId);

    if(empty($result) || $result['userId'] != $userId)
      throw new ContentModelNotFound();
  }
}
