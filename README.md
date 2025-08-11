
#  Laravel 11 Role-Based Article Management API

A Laravel 11 REST API for managing articles with role-based access control.

---

##  Requirements

- PHP 8.2.12
- Laravel 11
- Sanctum (for API authentication)

---

## 👤 Roles & Permissions

| Role   | Permissions |
|--------|-------------|
| **Admin**  | `view-all-users`, `assign-roles`, `publish-article`, `delete-article`, `view-published` |
| **Editor** | `publish-article`, `view-published` |
| **Author** | `create-article`, `edit-own-article`, `view-own-articles`, `view-published` |

---

##  Seeders

Run the following commands to seed roles and users:

```bash
php artisan db:seed
```

###  Default Users

| Role   | Email              | Password    |
|--------|--------------------|-------------|
| Admin  | admin@example.com  | password123 |
| Editor | editor@example.com | password123 |
| Author | author@example.com | password123 |

---


##  Authentication

###  POST `/api/login`

**Request**
```json
{
  "email": "author@example.com",
  "password": "password123"
}
```

**Response**
```json
{
  "status": "success",
  "message": "Success",
  "data": {
    "accessToken": "ACCESS_TOKEN",
    "user": {
      "id": 3,
      "name": "Author User",
      "email": "author@example.com",
      "roles": ["author"],
      "permissions": [
        "create-article",
        "edit-own-article",
        "view-own-articles",
        "view-published"
      ]
    }
  }
}
```

---

###  POST `/api/register`

**Request**
```json
{
  "name": "dewan1",
  "email": "dewan1@gmail.com",
  "password": "password123"
}
```

**Response**
```json
{
  "status": "success",
  "message": "Success",
  "data": {
    "accessToken": "ACCESS_TOKEN",
    "user": {
      "id": 4,
      "name": "dewan1",
      "email": "dewan1@gmail.com",
      "roles": [],
      "permissions": []
    }
  }
}
```

---

###  POST `/api/logout`

**Headers**
```
Authorization: Bearer ACCESS_TOKEN
```
**Request**
```json
{
  "email":"author@example.com"
}
```
---

##  Article Endpoints

> All endpoints below require `Bearer Token` authentication.

---

###  GET `/api/articles`

List all **published** articles.

**Permission Required**: `view-published`

**Response**
```json
{
  "status": "success",
  "message": 200,
  "data": [
    {
      "id": 1,
      "title": "test one",
      "slug": "test-one",
      "body": "test body",
      "status": 2,
      "user_id": 1,
      "created_at": "2025-08-01T13:39:40.000000Z",
      "updated_at": "2025-08-01T13:39:49.000000Z"
    }
  ]
}
```

---

###  GET `/api/articles/mine`

List **user's own** articles.

**Permission Required**: `view-own-articles`

**Response**
```json
{
  "status": "success",
  "message": 200,
  "data": [
    {
      "id": 1,
      "title": "test one",
      "slug": "test-one",
      "body": "test body",
      "status": 1,
      "user_id": 1,
      "created_at": "2025-08-01T13:39:40.000000Z",
      "updated_at": "2025-08-01T13:39:49.000000Z"
    }
  ]
}
```

---

###  POST `/api/articles`

Create a new article.

**Permission Required**: `create-article`

**Request**
```json
{
  "title": "test one",
  "slug": "slug one",
  "body": "test body"
}
```

**Response**
```json
{
  "status": "success",
  "message": 201,
  "data": {
    "id": 2,
    "title": "test one",
    "slug": "slug-one",
    "body": "test body",
    "status": 1,
    "user_id": 1,
    "created_at": "...",
    "updated_at": "..."
  }
}
```

---

###  PUT `/api/articles`

Update your own article.

**Permission Required**: `edit-own-article`

**Request**
```json
{
  "title": "test one 1",
  "slug": "slug one",
  "body": "test body"
}
```

**Response**
```json
{
    "status": "success",
    "message": 200,
    "data": {
        "id": 1,
        "title": "test one 1",
        "slug": "test-one-1",
        "body": "test body 1",
        "status": 1,
        "user_id": 1,
        "created_at": "2025-08-01T13:39:40.000000Z",
        "updated_at": "2025-08-11T09:10:07.000000Z"
    }
}
```

---

###  DELETE `/api/articles`

Delete an article by ID.

**Permission Required**: `delete-article`

**Request**
```json
{
  "id": 1
}
```

**Response**
```json
{
  "message": "Article deleted."
}
```

---

###  PATCH `/api/articles/{id}/publish`

Publish an article.

**Permission Required**: `publish-article`

**Request**
```json
{
  "status": 1
}
```

**Response**
```json
{
  "message": "Article published."
}
```

---
---

###  GET `/api/users`

List all users

**Permission Required**: `view-published`

**Response**
```json
{
    "status": "success",
    "message": "get user successfully",
    "data": [
        {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "email_verified_at": null,
            "created_at": "2025-08-01T11:41:01.000000Z",
            "updated_at": "2025-08-01T11:41:01.000000Z"
        },
        {
            "id": 2,
            "name": "Editor User",
            "email": "editor@example.com",
            "email_verified_at": null,
            "created_at": "2025-08-01T11:41:01.000000Z",
            "updated_at": "2025-08-01T11:41:01.000000Z"
        },
        {
            "id": 3,
            "name": "Author User",
            "email": "author@example.com",
            "email_verified_at": null,
            "created_at": "2025-08-01T11:41:01.000000Z",
            "updated_at": "2025-08-01T11:41:01.000000Z"
        },
        {
            "id": 4,
            "name": "dewan1",
            "email": "dewan1@gmail.com",
            "email_verified_at": null,
            "created_at": "2025-08-11T04:30:39.000000Z",
            "updated_at": "2025-08-11T04:30:39.000000Z"
        }
    ]
}
```

---

##  Support

For questions or issues, please open a GitHub issue.

