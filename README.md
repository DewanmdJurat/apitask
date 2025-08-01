Overview
This project is a Laravel 11-based REST API implementing user roles and permissions with Sanctum authentication.
The API includes features like user management, article CRUD, and role/permission based access control.

Branches
master: Active development branch

main: Stable production branch — merges from master

You should work locally on master and merge into main when ready.

Requirements
PHP 8.1 or higher (required by Laravel 11)

Composer

Installation Steps
Clone the repository and checkout master branch:

bash
Copy
Edit
git clone <repo-url>
git checkout master
Install PHP dependencies:

Make sure you have PHP 8.1+ installed on your machine, then run:

bash
Copy
Edit
composer install
Set up your .env file:

Copy .env.example to .env and configure your database and other environment variables.

Run migrations and seeders:

bash
Copy
Edit
php artisan migrate --seed
This will create tables and seed roles, permissions, and three default users.

Seeders Info:

The seeder creates the following roles and users:

Roles: admin, editor, author

Users: Three users are created (see database/seeders for details).

Permissions are also seeded and attached to roles.

Testing the API
I shared a postman file in project base path(apitask.json)

The collection includes:

User registration and login

Role assignment (admin only)

Article CRUD operations

Permission-protected routes

For authenticated requests, include the Bearer Token from login responses.
