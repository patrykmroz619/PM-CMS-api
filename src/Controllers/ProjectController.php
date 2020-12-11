<?php

declare(strict_types=1);

namespace API\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\ProjectService;

class ProjectController {
  private ProjectService $projectService;

  public function __construct(ProjectService $projectService)
  {
    $this->projectService = $projectService;
  }

  public function addProject(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $projectData = $this->projectService->addProject($body);

    $response->getBody()->write(json_encode($projectData));
    return $response->withStatus(201);
  }

  public function getProjects(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $projects = $this->projectService->getProjects($body['uid']);

    $responseData = ['projects' => $projects];

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }

  public function getProjectById (Request $request, Response $response, string $id): Response
  {
    $project = $this->projectService->getOneProject($id);

    $response->getBody()->write(json_encode($project));
    return $response;
  }

  public function updateProject (Request $request, Response $response, string $id): Response
  {
    $body = $request->getParsedBody();
    $updatedProject = $this->projectService->updateProject($id, $body);

    $response->getBody()->write(json_encode($updatedProject));
    return $response;
  }

  public function deleteProject (Request $request, Response $response, string $id): Response
  {
    $this->projectService->deleteProject($id);

    $response->getBody()->write(json_encode([]));
    return $response->withStatus(204);
  }
}
