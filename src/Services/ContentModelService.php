<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\ContentModelExceptions\ContentModelAlreadyExistsException;
use Api\AppExceptions\ContentModelExceptions\EndpointIsNotUniqueException;
use Api\Models\ContentModel;
use Api\Validators\ContentModelDataValidator;

class ContentModelService
{
  private ContentModelDataValidator $contentModelDataValidator;
  private ContentModel $contentModel;

  public function __construct()
  {
    $this->contentModelDataValidator = new ContentModelDataValidator();
    $this->contentModel = new ContentModel();
  }
  public function create(array $requestData): array
  {
    $dataToSave = $this->processNewContentModelData($requestData);

    $result = $this->contentModel->insertOne($dataToSave);
    $dataToSave['id'] = $result->getInsertedId()->__toString();

    return $dataToSave;
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

    $this->checkThatEndpointIsUnique($data['projectId'], $contentModelData['endpoint']);

    return $contentModelData;
  }

  // private function checkThatProjectNameIsUnique( string $userId, string $name, string $id): bool
  // {
  //   $result = $this->projectModel->findMany(
  //     ['userId' => $userId, 'name' => $name]
  //   );

  //   foreach($result as $project)
  //   {
  //     if($project['name'] === $name && $project['id'] != $id)
  //       throw new ProjectNameIsNotUniqueException();
  //   }

  //   return true;
  // }

  private function checkThatEndpointIsUnique( string $userId, string $endpoint, string $id = null): bool
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
