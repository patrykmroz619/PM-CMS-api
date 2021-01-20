# Get contents model for project

```http
GET /content-models/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `200`

### body

```typeScript
{
  array[ContentModel]
}
```

ContentModel object:

```typeScript
{
  "id": string,
  "name": string,
  "endpoint": string,
  "fields": array,
  "userId": string,
  "projectId": string
}
```

# Add content model to project

```http
POST /content-models/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  "name": string,
  "endpoint": string
}
```

## Succes response

- status: `201`

### body

```typeScript
{
  "id": string,
  "name": string,
  "endpoint": string,
  "fields": array,
  "userId": string,
  "projectId": string
}
```

## Error responses

| Status |         type         |                    Description                     |
| :----: | :------------------: | :------------------------------------------------: |
| `400`  | CONTENT_MODEL_EXISTS | The content model with passed name already exists. |
| `400`  | ENDPOINT_NOT_PASSED  |  The content model's api endpoint was not passed.  |
| `400`  |   NAME_NOT_PASSED    |      The content model's name was not passed.      |
| `400`  | ENDPOINT_NOT_UNIQUE  |  The content model's api endpoint is not unique.   |

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

# Update content model

```http
PATCH /content-models/{contentModelId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  "name": string | undefined,
  "endpoint": string | undefined,
}
```

## Succes response

- status: `201`

### body

```typeScript
{
  "id": string,
  "name": string,
  "endpoint": string,
  "fields": array,
  "userId": string,
  "projectId": string
}
```

## Error responses

| Status |        type         |                   Description                   |
| :----: | :-----------------: | :---------------------------------------------: |
| `400`  |   NAME_NOT_UNIQUE   |     The content model's name is not unique.     |
| `400`  | ENDPOINT_NOT_UNIQUE | The content model's api endpoint is not unique. |

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

# Delete content model from project

```http
DELETE /content-models/{contentModelId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- status: `204`

- empty response body

## Error responses

| Status |          type           |           Description            |
| :----: | :---------------------: | :------------------------------: |
| `400`  | CONTENT_MODEL_NOT_FOUND | The content model was not found. |

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
