<?php

declare(strict_types=1);

namespace Api\Services\Project;

use Api\Models\Content\ContentModel;
use Api\Models\Project\ProjectModel;
use Api\Models\Record\RecordModel;

class DeleteProjectService
{
  private ProjectModel $projectModel;
  private ContentModel $contentModel;
  private RecordModel $recordModel;

  public function __construct()
  {
    $this->projectModel = new ProjectModel();
    $this->contentModel = new ContentModel();
    $this->recordModel = new RecordModel();
  }

  public function deleteProject(string $projectId, string $userId): void
  {
    $this->projectModel->deleteByIdAndUserId($projectId, $userId);

    $contentModels = $this->contentModel->findByProjectId($projectId);

    foreach($contentModels as $model) {
      $this->contentModel->deleteByIdAndUserId($model['id'], $userId);
      $this->recordModel->deleteManyByContentModelId($model['id']);
    }
  }

  public function deleteManyByUserId(string $userId): void
  {
    $projects = $this->projectModel->findByUserId($userId);

    foreach($projects as $project) {
      $this->deleteProject($project['id'], $userId);
    }
  }
}
