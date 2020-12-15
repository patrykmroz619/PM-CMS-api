<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ContentModelExceptions\ContentModelAlreadyExistsException;
use Api\AppExceptions\ContentModelExceptions\ContentModelNameIsNotUnique;
use Api\AppExceptions\ContentModelExceptions\ContentModelNotFound;
use Api\AppExceptions\ContentModelExceptions\EndpointIsNotUniqueException;
use Api\Models\ContentModel;
use Api\Models\ProjectModel;
use Api\Validators\ContentModelDataValidator;

class ContentModelService
{
  private ContentModelDataValidator $contentModelDataValidator;
  private ContentModel $contentModel;
  private SecurityService $securityService;

  public function __construct()
  {
    $this->contentModelDataValidator = new ContentModelDataValidator();
    $this->contentModel = new ContentModel();
    $this->securityService = new SecurityService();
  }

  public function create(array $requestData): array
  {
    $dataToSave = $this->processNewContentModelData($requestData);

    $result = $this->contentModel->insertOne($dataToSave);
    $dataToSave['id'] = $result->getInsertedId()->__toString();

    return $dataToSave;
  }

  public function getContentModels(string $projectId, string $userId): array
  {
    $this->securityService->checkThatProjectBelongToUser($projectId, $userId, new ProjectModel());

    $result = $this->contentModel->findManyByProjectId($projectId);

    return $result;
  }

  public function updateContentModel(string $id, array $data): array
  {
    $dataToUpdate = $this->validateUpdateContentModel($id, $data['uid'], $data);

    $this->contentModel->updateById($id, $dataToUpdate);

    $updatedModel = $this->contentModel->findOneById($id);

    return $updatedModel;
  }

  public function delete(string $id, string $userId): void
  {
    $this->securityService->checkThatContentModelBelongToUser($id, $userId, $this->contentModel);

    $result = $this->contentModel->deleteById($id);

    if($result->getDeletedCount() == 0)
      throw new ContentModelNotFound();
  }

  private function processNewContentModelData(array $data): array
  {
    $contentModelData = $this->validateNewContentModel($data);

    if($contentModelData['endpoint'] === null) {
      $contentModelData['endpoint'] = $this->createSlug($contentModelData['name']);
    }

    $contentModelData['fields'] = [];
    $contentModelData['userId'] = $data['uid'];
    $contentModelData['projectId'] = $data['projectId'];

    return $contentModelData;
  }

  private function validateNewContentModel(array $data): array
  {
    $contentModelData = $this->contentModelDataValidator->validate($data);

    $contentModel = $this->contentModel->findOneByProjectIdAndName($data['projectId'], $contentModelData['name']);

    if(!!$contentModel)
      throw new ContentModelAlreadyExistsException();

    $this->checkThatContentModelEndpointIsUnique($data['projectId'], $contentModelData['endpoint']);

    return $contentModelData;
  }

  private function validateUpdateContentModel(string $id, string $userId, array $data): array
  {
    $this->securityService->checkThatContentModelBelongToUser($id, $userId, $this->contentModel);

    $dataToUpdate = $this->contentModelDataValidator->validateToUpdate($data);

    if(isset($dataToUpdate['name']))
      $this->checkThatContentModelNameIsUnique($userId, $dataToUpdate['name'], $id);

    if(isset($dataToUpdate['endpoint']))
      $this->checkThatContentModelEndpointIsUnique($userId, $dataToUpdate['endpoint'], $id);

    return $dataToUpdate;
  }

  private function checkThatContentModelNameIsUnique( string $userId, string $name, string $id): bool
  {
    $result = $this->contentModel->findMany(
      ['userId' => $userId, 'name' => $name]
    );

    foreach($result as $project)
    {
      if($project['name'] === $name && $project['id'] != $id)
        throw new ContentModelNameIsNotUnique();
    }

    return true;
  }

  private function checkThatContentModelEndpointIsUnique( string $userId, string $endpoint, string $id = null): bool
  {
    $result = $this->contentModel->findMany(
      ['projectId' => $userId, 'endpoint' => $endpoint]
    );

    foreach($result as $contentModel)
    {
      if($id) {
        if($contentModel['endpoint'] === $endpoint && $contentModel['id'] != $id)
          throw new EndpointIsNotUniqueException();
      } else {
        if($contentModel['endpoint'] === $endpoint)
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
