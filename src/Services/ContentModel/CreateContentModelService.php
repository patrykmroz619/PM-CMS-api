<?php

declare(strict_types=1);

namespace Api\Services\ContentModel;

use Api\AppExceptions\ContentModelExceptions\ContentModelAlreadyExistsException;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\Helpers\SlugGenerator;
use Api\Models\Content\ContentModel;
use Api\Models\Project\ProjectModel;
use Api\Validators\ContentModelData\NewContentModelDataValidator;

class CreateContentModelService extends AbstractContentModelService
{
  private NewContentModelDataValidator $validator;
  protected ContentModel $contentModel;
  private ProjectModel $projectModel;

  public function __construct()
  {
    $this->validator = new NewContentModelDataValidator();
    $this->contentModel = new ContentModel();
    $this->projectModel = new ProjectModel();
  }

  public function create(string $projectId, array $data): array
  {
    $dataToSave = $this->processData($projectId, $data);

    $newContenModelId = $this->contentModel->create($dataToSave);
    $dataToSave['id'] = $newContenModelId;

    return $dataToSave;
  }

  private function processData(string $projectId, array $data): array
  {
    $contentModelData = $this->validate($projectId, $data);

    $contentModelData['fields'] = [];
    $contentModelData['userId'] = $data['uid'];
    $contentModelData['projectId'] = $projectId;

    return $contentModelData;
  }

  private function validate(string $projectId, array $data): array
  {
    $project = $this->projectModel->findById($projectId);

    if(empty($project))
      throw new ProjectNotFoundException();

    $contentModelData = $this->validator->validate($data);

    $contentModel = $this->contentModel->findByProjectIdAndName($projectId, $contentModelData['name']);

    if(!!$contentModel)
      throw new ContentModelAlreadyExistsException();

    $this->checkThatContentModelEndpointIsUnique($projectId, $contentModelData['endpoint']);

    return $contentModelData;
  }
}
