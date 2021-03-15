<?php

declare(strict_types=1);

namespace Api\Services\ContentModel;

use Api\AppExceptions\ContentModelExceptions\ContentModelNameIsNotUnique;
use Api\AppExceptions\ContentModelExceptions\EndpointIsNotUniqueException;

abstract class AbstractContentModelService
{
  protected function checkThatContentModelNameIsUnique( string $projectId, string $name, string $id): bool
  {
    $contentModels = $this->contentModel->findByProjectId($projectId);

    foreach($contentModels as $model)
    {
      if($model['name'] === $name && $model['id'] != $id)
        throw new ContentModelNameIsNotUnique();
    }

    return true;
  }

  protected function checkThatContentModelEndpointIsUnique( string $projectId, string $endpoint, string $id = null): bool
  {
    $contentModels = $this->contentModel->findByProjectId($projectId);

    foreach($contentModels as $model)
    {
      if($id) {
        if($model['endpoint'] === $endpoint && $model['id'] != $id)
          throw new EndpointIsNotUniqueException();
      } else {
        if($model['endpoint'] === $endpoint)
          throw new EndpointIsNotUniqueException();
      }
    }

    return true;
  }
}
