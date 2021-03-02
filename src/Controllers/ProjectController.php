<?php

declare(strict_types=1);

namespace API\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use Api\Models\Project\ProjectModel;
use Api\Services\Project\ProjectApiKeyService;
use Api\Services\Project\ProjectCreatorService;
use Api\Services\Project\UpdateProjectService;

class ProjectController {
  private ProjectCreatorService $projectCreatorService;
  private UpdateProjectService $updateProjectService;
  private ProjectApiKeyService $projectApiKeyService;
  private ProjectModel $projectModel;

  public function __construct(
    ProjectCreatorService $projectCreatorService,
    UpdateProjectService $updateProjectService,
    ProjectApiKeyService $projectApiKeyService,
    ProjectModel $projectModel
  )
  {
    $this->projectCreatorService = $projectCreatorService;
    $this->updateProjectService = $updateProjectService;
    $this->projectApiKeyService = $projectApiKeyService;
    $this->projectModel = $projectModel;
  }

  public function createProject(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $projectData = $this->projectCreatorService->create($body);

    $response->getBody()->write(json_encode($projectData));
    return $response->withStatus(201);
  }

  public function getProjects(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $projects = $this->projectModel->findByUserId($body['uid']);

    $responseData = ['projects' => $projects];

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function getProjectById(Request $request, Response $response, string $id): Response
  {
    $body = $request->getParsedBody();

    $project = $this->projectModel->findById($id);

    if($project['userId'] != $body['uid'])
      throw new ProjectNotFoundException();

    $response->getBody()->write(json_encode($project));
    return $response;
  }

  public function updateProject(Request $request, Response $response, string $id): Response
  {
    $body = $request->getParsedBody();
    $updatedProject = $this->updateProjectService->update($id, $body);

    $response->getBody()->write(json_encode($updatedProject));
    return $response;
  }

  public function deleteProject(Request $request, Response $response, string $id): Response
  {
    $body = $request->getParsedBody();

    $this->projectModel->deleteByIdAndUserId($id, $body['uid']);

    $response->getBody()->write(json_encode([]));
    return $response->withStatus(204);
  }

  public function generateApiKey(Request $request, Response $response, string $id): Response
  {
    $body = $request->getParsedBody();

    $apiKey = $this->projectApiKeyService->generateApiKey($id, $body['uid']);

    $responseBody = ['apiKey' => $apiKey];

    $response->getBody()->write(json_encode($responseBody));
    return $response->withStatus(201);
  }
}
