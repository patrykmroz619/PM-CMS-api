# Add field to content model

```http
POST /content-model-fields/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The request body have to contain one of field's objects.

### List of field's objects

- Text field

```typeScript
{
  "id": string,
  "type": "text",
  "name": string,
  "multiline": boolean,
  "unique": boolean,
  "maxLendgth": number | undefined,
  "minLength": number | undefined
}
```

- Number field

```typeScript
{
  "id": string,
  "type": "number"
  "name": string,
  "unique": boolean,
  "integer": boolean,
  "max": number | undefined,
  "min": number | undefined
}
```

- Boolean field

```typeScript
{
  "id": string,
  "type": "number",
  "name": string
}
```

- Color field

```typeScript
{
  "id": string,
  "type": "color"
  "name": string,
}
```

## Succes response

- status: `201`

### body

Response body contain one of field's objects from list.

## Error responses

| Status |           type            |                         Description                         |
| :----: | :-----------------------: | :---------------------------------------------------------: |
| `400`  |       FIELD_EXISTS        |     The content field with passed name already exists.      |
| `400`  |   FIELD_TYPE_NOT_PASSED   |     The type property of content field was not passed.      |
| `400`  |    INVALID_FIELD_TYPE     |     The type property of the content field is invalid.      |
| `400`  |    INVALID_FIELD_DATA     |     The name property of the content field is required.     |
| `400`  |    INVALID_FIELD_DATA     | The name of content field can be maximum of 35 characters.. |
| `400`  |  INVALID_TEXT_FIELD_DATA  |    The unique property of the content field is required.    |
| `400`  |  INVALID_TEXT_FIELD_DATA  |   The boolean is an expected type of the unique property.   |
| `400`  |  INVALID_TEXT_FIELD_DATA  |  The multiline property of the content field is required.   |
| `400`  |  INVALID_TEXT_FIELD_DATA  | The boolean is an expected type of the multiline property.  |
| `400`  |  INVALID_TEXT_FIELD_DATA  |      The minLength property is not an integer number.       |
| `400`  |  INVALID_TEXT_FIELD_DATA  |      The maxLength property is not an integer number.       |
| `400`  | INVALID_NUMBER_FIELD_DATA |              The min property is not a number.              |
| `400`  | INVALID_NUMBER_FIELD_DATA |              The max property is not a number.              |
| `400`  | INVALID_NUMBER_FIELD_DATA |   The integer property of the content field is required.    |
| `400`  | INVALID_NUMBER_FIELD_DATA |  The boolean is an expected type of the integer property.   |
| `400`  | INVALID_COLOR_FIELD_DATA  |     The value property of the color field is required.      |
| `400`  | INVALID_COLOR_FIELD_DATA  |      The value property of the color field is invalid.      |

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

# Update field in content model

```http
POST /content-model-fields/{projectId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

The request body have to contain one of field's objects.

## Succes response

- status: `200`

### body

Response body contain one of field's objects from list.

## Error responses

| Status |           type            |                         Description                         |
| :----: | :-----------------------: | :---------------------------------------------------------: |
| `400`  |       FIELD_EXISTS        |     The content field with passed name already exists.      |
| `400`  |   FIELD_TYPE_NOT_PASSED   |     The type property of content field was not passed.      |
| `400`  |    INVALID_FIELD_TYPE     |     The type property of the content field is invalid.      |
| `400`  |    INVALID_FIELD_DATA     |     The name property of the content field is required.     |
| `400`  |    INVALID_FIELD_DATA     | The name of content field can be maximum of 35 characters.. |
| `400`  |  INVALID_TEXT_FIELD_DATA  |    The unique property of the content field is required.    |
| `400`  |  INVALID_TEXT_FIELD_DATA  |   The boolean is an expected type of the unique property.   |
| `400`  |  INVALID_TEXT_FIELD_DATA  |  The multiline property of the content field is required.   |
| `400`  |  INVALID_TEXT_FIELD_DATA  | The boolean is an expected type of the multiline property.  |
| `400`  |  INVALID_TEXT_FIELD_DATA  |      The minLength property is not an integer number.       |
| `400`  |  INVALID_TEXT_FIELD_DATA  |      The maxLength property is not an integer number.       |
| `400`  | INVALID_NUMBER_FIELD_DATA |              The min property is not a number.              |
| `400`  | INVALID_NUMBER_FIELD_DATA |              The max property is not a number.              |
| `400`  | INVALID_NUMBER_FIELD_DATA |   The integer property of the content field is required.    |
| `400`  | INVALID_NUMBER_FIELD_DATA |  The boolean is an expected type of the integer property.   |
| `400`  | INVALID_COLOR_FIELD_DATA  |     The value property of the color field is required.      |
| `400`  | INVALID_COLOR_FIELD_DATA  |      The value property of the color field is invalid.      |

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

# Delete field from content model

```http
DELETE /content-model-fields/{contentModelId}
```

- Request header: `Authorization: "bearer <accessToken>"`

## Request body

```typeScript
{
  "name": string
}
```

## Succes response

- status: `204`

- empty response body

## Error responses

| Status |          type           |             Description              |
| :----: | :---------------------: | :----------------------------------: |
| `400`  |      ID_NOT_PASSED      | Id of content fields was not passed. |
| `404`  | CONTENT_FIELD_NOT_FOUND |   The content field was not found.   |

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
