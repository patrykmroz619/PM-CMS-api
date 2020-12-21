# Register

```http
POST /register
```

- auth required: `false`

## Request body

```typeScript
{
  "email": string,
  "password": string,
  "name": string | undefined, //optional
  "surname": string | undefined, //optional
  "company": string | undefined //optional
}
```

## Succes response

- Status: `200`

### Response body

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

| Status |         type         |                    Description                    |
| :----: | :------------------: | :-----------------------------------------------: |
| `400`  |   EMAIL_NOT_PASSED   |         The email address was not passed.         |
| `400`  | PASSWORD_NOT_PASSED  |           The password was not passed.            |
| `400`  |    INVALID_EMAIL     |          The email address is not valid.          |
| `400`  |     INVALID_NAME     |              The name is not valid.               |
| `400`  |   INVALID_SURNAME    |             The surname is not valid.             |
| `400`  | INVALID_COMPANY_NAME |          The company name is not valid.           |
| `401`  |     USER_EXISTS      | An user with passed email address already exists. |

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
