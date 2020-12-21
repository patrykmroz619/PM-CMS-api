# Refresh token

```http
POST /refresh
```

- Request header: `Authorization: "bearer <refreshToken>"`

## Request body

The body of request should be empty.

## Succes response

- Status: `200`

### Response body

```typeScript
{
  "accessToken": string,
  "refreshToken": string
}
```

## Error Responses

| Status |         type          |               Description                |
| :----: | :-------------------: | :--------------------------------------: |
| `401`  | INVALID_REFRESH_TOKEN | The refresh token is invalid or expired. |

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
