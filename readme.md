# PM CMS - Headless CMS Rest API

<details open="open">
  <summary>Table of concept</summary>
  <ol>
    <li><a href="#about-the-project">About the project</a></li>
    <li><a href="#local-usage">Usage</a></li>
    <li><a href="#technologies">Technologies</a></li>
    <li><a href="#api-docs">Api docs</a></li>
  </ol>
</details>

## About the project

---

The rest api for my project called "PM CMS - Headless CMS" created with PHP, Slim Framework and Mongo DB.

## Local usage

---

1. Clone the repo

```sh
git clone <repo-url>
```

2. Install packages

```sh
composer install
```

3. Run api locally on localhost:8000

```sh
composer run-api
```

## Technologies

---

- [php 7.4.7](https://www.php.net/)
- [Slim framework](https://www.slimframework.com/)
- [MongoDB](https://www.mongodb.com/)

## Api docs

---

### Public routes

- [Login](docs/login.md) : `/login`

- [Register](docs/register.md) : `/register`

- [Refresh JWT](docs/refresh.md) : `/refresh`

### Private routes

- [Users](docs/users.md) : `/users`

- [Projects](docs/projects.md) : `/projects`

- [Content models](docs/content-models.md) : `/content-models`

- [Content model fields](docs/content-fields.md) : `/content-model-fields`

- [Records](docs/records.md) : `/records`
