# Get all records from content model

```http
GET /api/{contentModelEndpoint}
```

- Request header: `Authorization: "bearer <apiKey>"`

## Request body

The body of request should be empty.

## Succes response

- status: `200`

```typeScript
{
  contentModelName: string
  records: Array<Record>
}
```

## Error responses

| Status |         type          |            Description             |
| :----: | :-------------------: | :--------------------------------: |
| `401`  |     ACCESS_DENIED     | Access denied, api token is wrong. |
| `404`  | 'CONTENT_MODEL_ERROR' |  The content model was not found.  |

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

# Get single record from content model

```http
GET /api/{contentModelEndpoint}/{recordId}
```

- Request header: `Authorization: "bearer <apiKey>"`

## Request body

The body of request should be empty.

## Succes response

- status: `200`

```typeScript
{
  contentModelName: string
  record: Record
}
```

## Error responses

| Status |         type          |            Description             |
| :----: | :-------------------: | :--------------------------------: |
| `401`  |     ACCESS_DENIED     | Access denied, api token is wrong. |
| `404`  | 'CONTENT_MODEL_ERROR' |  The content model was not found.  |
| `404`  | 'CONTENT_MODEL_ERROR' |  The content model was not found.  |
| `404`  |  'RECORD_NOT_FOUND'   |     The record was not found.      |

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
