<?php

declare(strict_types=1);

namespace Api\Services\ContentModel;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use Api\Models\Content\ContentModel;
use Api\Validators\ContentModelData\UpdateContentModelDataValidator;

class UpdateContentModelService extends AbstractContentModelService
{
  private UpdateContentModelDataValidator $validator;
  protected ContentModel $contentModel;

  public function __construct()
  {
    $this->validator = new UpdateContentModelDataValidator();
    $this->contentModel = new ContentModel();
  }

  public function update(string $contentModelId, array $data): array
  {
    $dataToUpdate = $this->validate($contentModelId, $data['uid'], $data);

    $result = $this->contentModel->updateByIdAndUserId($contentModelId, $data['uid'], $dataToUpdate);

    if($result->getMatchedCount() == 0)
      throw new ContentModelNotFoundException();

    $updatedModel = $this->contentModel->findByIdAndUserId($contentModelId, $data['uid']);

    return $updatedModel;
  }

  private function validate(string $contentModelId, string $userId, array $data): array
  {
    $dataToUpdate = $this->validator->validate($data);

    $modelBeforeUpdate = $this->contentModel->findByIdAndUserId($contentModelId, $userId);

    $projectId = $modelBeforeUpdate['projectId'];

    if(isset($dataToUpdate['name']))
      $this->checkThatContentModelNameIsUnique($projectId, $dataToUpdate['name'], $contentModelId);

    if(isset($dataToUpdate['endpoint']))
      $this->checkThatContentModelEndpointIsUnique($projectId, $dataToUpdate['endpoint'], $contentModelId);

    return $dataToUpdate;
  }
}
