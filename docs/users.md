# Update user

```http
PATCH /users
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  "email": string | undefined,
  "password": string | undefined,
  "name": string | undefined,
  "surname": string | undefined,
  "company": string | undefined,
}
```

## Succes response

- Status: `200`

- body

```typeScript
{
  "id": string,
  "email": string,
  "name": string | null,
  "surname": string | null,
  "company": string | null
}
```

## Error responses

| Status |         type         |               Description                |
| :----: | :------------------: | :--------------------------------------: |
| `400`  |    INVALID_EMAIL     |     The email address is not valid.      |
| `400`  |     INVALID_NAME     |          The name is not valid.          |
| `400`  |   INVALID_SURNAME    |        The surname is not valid.         |
| `400`  | INVALID_COMPANY_NAME |      The company name is not valid.      |
| `400`  |    USER_NOT_FOUND    | The user with passed email is not found. |

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

# Delete user

```http
DELETE /users
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The body of request should be empty.

## Succes response

- status: `204`

- empty response body

## Error responses

| Status |     type     |           Description            |
| :----: | :----------: | :------------------------------: |
| `400`  | DELETE_ERROR | Deleting user was not completed. |

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
