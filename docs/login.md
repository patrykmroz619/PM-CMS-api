# Login

```http
POST /login
```

- auth required: `false`

## Request body

```typeScript
{
  "email": string,
  "password": string
}
```

## Succes response

- Status: `200`

- body

```typeScript
{
  "userData": {
    "id": string,
    "email": string,
    "name": string | null,
    "surname": string | null,
    "company": string | null
  },
  "tokens": {
    "accessToken": string,
    "refreshToken": string
  }
}
```

## Error Responses

| Status |       type       |               Description                |
| :----: | :--------------: | :--------------------------------------: |
| `401`  | INVALID_PASSWORD |         The password is invalid.         |
| `401`  |  USER_NOT_FOUND  | The user with passed email is not found. |

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
