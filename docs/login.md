# Login

```http
POST /login
```

- auth required: `false`

## Request body

```json
{
  "email": "string",
  "password": "string"
}
```

## Succes response

- Status: `200`

- body

```json
{
  "userData": {
    "uid": "string",
    "email": "string",
    "name": "string or null",
    "surname": "string or null",
    "company": "string or null"
  },
  "tokens": {
    "activeToken": "string",
    "refreshToken": "string"
  }
}
```

## Error Responses

| Status |       type       |               Description                |
| :----: | :--------------: | :--------------------------------------: |
| `401`  | INVALID_PASSWORD |         The password is invalid.         |
| `401`  |  USER_NOT_FOUND  | The user with passed email is not found. |

### Response body

```json
{
  "statusCode": status,
  "error": {
    "type": type,
    "description": description
  }
}
```
