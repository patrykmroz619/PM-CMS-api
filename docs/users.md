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

- Status: `201`

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

# Change password

```http
PUT /users/password
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typescript
{
  "currentPassword": string,
  "newPassword": string
}
```

## Succes response

- status: `201`

- empty response body

## Error responses

| Status |           type           |               Description               |
| :----: | :----------------------: | :-------------------------------------: |
| `400`  | PASSWORD_WAS_NOT_UPDATED |  The passed password was not updated.   |
| `400`  |   PASSWORD_NOT_PASSED    |      The password was not passed.       |
| `400`  | INVALID_CURRENT_PASSWORD | The passed current password is invalid. |
| `400`  |   INVALID_NEW_PASSWORD   |   The passed new password is invalid.   |
| `400`  |     INVALID_PASSWORD     |      _Information about an error_       |

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
