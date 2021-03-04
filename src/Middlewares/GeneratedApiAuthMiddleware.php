<?php

declare (strict_types=1);

namespace Api\Middlewares;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Api\AppExceptions\GeneratedApiExceptions\AccessDeniedException;
use Api\Models\Project\ProjectModel;
use Api\Services\Token\GeneratedApiTokenService;
use Exception;

class GeneratedApiAuthMiddleware {
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = GeneratedApiTokenService::getTokenFromRequest($request);
    $tokenArray = (array) GeneratedApiTokenService::validateToken($token);

    if(!empty($tokenArray) && isset($tokenArray['apiKey'])) {
      $this->checkIfTheProjectIsPublished($tokenArray);
      return $handler->handle($this->applyDataFromTokenToRequestBody($request, $tokenArray));
    }
    else
      throw new AccessDeniedException();
  }

  private function checkIfTheProjectIsPublished(array $tokenArray): void
  {
    try {
      $projectModel = new ProjectModel();
      $project = $projectModel->findById($tokenArray['projectId']);
    } catch (Exception $e) {
      throw new AccessDeniedException();
    }

    if(!$project['published'])
      throw new ContentModelNotFoundException();
  }

  private function applyDataFromTokenToRequestBody(Request $request, array $tokenArray): Request
  {
    try {
      $parsedBody = $request->getParsedBody();
      $tokenData = ['projectId' => $tokenArray['projectId'], 'userId' => $tokenArray['userId']];
      $requestBody = array_merge($parsedBody ?? [], $tokenData);
      return $request->withParsedBody($requestBody);
    } catch (Exception $e) {
      throw new AccessDeniedException();
    }
  }
}
