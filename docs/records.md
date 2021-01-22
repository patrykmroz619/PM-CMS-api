# Get records

```http
GET /records/{contentModelId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `200`

### body

```typeScript
{
  array<
    {
      "id": string
      "userId": string,
      "contentModelId": string,
      "data": array<
        {
          "name": string
          "value": string | number | boolean
        }
      >
    }
  >
}
```

# Add record

```http
POST /records/{contentModelId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  "record": array<
    {
      "name": string,
      "value": string | number | boolean
    }
  >
}
```

## Succes response

- Status: `200`

### body

```typeScript
{
  "id": string
  "userId": string,
  "contentModelId": string,
  "data": array<
    {
      "name": string
      "value": string | number | boolean
    }
  >
}
```

## Error responses

| Status |          type          |                  Description                   |
| :----: | :--------------------: | :--------------------------------------------: |
| `400`  | RECORD_DATA_NOT_PASSED |          Record data was not passed.           |
| `400`  |  INVALID_RECORD_DATA   |             Invalid record's data.             |
| `400`  |      RECORD_ERROR      | Invalid value of [field name]: [error message] |

## Update record

```http
PUT /records/{recordId}
```

- Request header: `Authorization: "bearer <accessToken>"`

- Request body, success and error responses are the same as for adding records.

## Delete record

```http
DELETE /records/{recordId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `204`

## Error responses

| Status |       type       |      Description       |
| :----: | :--------------: | :--------------------: |
| `400`  | RECORD_NOT_FOUND | Record was not passed. |
