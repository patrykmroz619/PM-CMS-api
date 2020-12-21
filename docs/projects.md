# Get projects

```http
GET /projects
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `200`

### body

```typeScript
{
  "projects": array
}
```

# Get projects by id

```http
GET /projects/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `200`

### body

```typeScript
{
  "id": string,
  "userId": string,
  "name": string,
  "createdAt": timestamp,
  "updatedAt": timestamp,
  "published": boolean
}
```

## Error responses

| Status |       type        |        Description         |
| :----: | :---------------: | :------------------------: |
| `400`  | PROJECT_NOT_FOUND | The project was not found. |

### Response body

```typeScript
{
  "statusCode": status,
  "error": {
    "type": type,
    "description": description
  }
}
```

# Create project

```http
POST /projects
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  name: string
}
```

## Succes response

- status: `201`

### body

```typeScript
{
  "id": string,
  "userId": string,
  "name": string,
  "createdAt": timestamp,
  "updatedAt": timestamp,
  "published": boolean
}
```

## Error responses

| Status |         type         |                Description                 |
| :----: | :------------------: | :----------------------------------------: |
| `400`  |    PROJECT_EXISTS    | A project with passed name already exists. |
| `400`  | INVALID_PROJECT_NAME |       The project name is not valid.       |

### Response body

```typeScript
{
  "statusCode": status,
  "error": {
    "type": type,
    "description": description
  }
}
```

# Update project

```http
PATCH /projects/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  name: string | undefined,
  published: boolean | undefined,
}
```

## Succes response

- status: `201`

### body

```typeScript
{
  "id": string,
  "userId": string,
  "name": string,
  "createdAt": timestamp,
  "updatedAt": timestamp,
  "published": true
}
```

## Error responses

| Status |          type           |                       Description                       |
| :----: | :---------------------: | :-----------------------------------------------------: |
| `400`  | INVALID_PUBLISHED_VALUE | The published property has not a value of boolean type. |
| `400`  |  INVALID_PROJECT_NAME   |             The project name is not valid.              |

### Response body

```typeScript
{
  "statusCode": status,
  "error": {
    "type": type,
    "description": description
  }
}
```

# Delete project

```http
DELETE /projects/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- status: `204`

- empty response body

## Error responses

| Status |       type        |        Description         |
| :----: | :---------------: | :------------------------: |
| `400`  | PROJECT_NOT_FOUND | The project was not found. |

### Response body

```typeScript
{
  "statusCode": status,
  "error": {
    "type": type,
    "description": description
  }
}
```
