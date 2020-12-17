# Register

```http
POST /register
```

- auth required: `false`

## Request body

```json
{
  "email": "string",
  "password": "string",
  "name": "string", //optional
  "surname": "string", //optional
  "company": "string" //optional
}
```

## Succes response

- Status: `200`

### Response body

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

| Status |         type         |                    Description                    |
| :----: | :------------------: | :-----------------------------------------------: |
| `400`  |   EMAIL_NOT_PASSED   |         The email address was not passed.         |
| `400`  | PASSWORD_NOT_PASSED  |           The password was not passed.            |
| `401`  |    INVALID_EMAIL     |          The email address is not valid.          |
| `401`  |     INVALID_NAME     |              The name is not valid.               |
| `401`  |   INVALID_SURNAME    |             The surname is not valid.             |
| `401`  | INVALID_COMPANY_NAME |          The company name is not valid.           |
| `401`  |     USER_EXISTS      | An user with passed email address already exists. |

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
