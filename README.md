# Food Label Maker API

This is a Laravel 12 RESTful API project that uses Sanctum for authentication and supports both user and admin roles.

## Requirements

- PHP 8.2+
- Composer
- Docker & Docker Compose
- Node.js & npm (optional if you want to compile front-end assets)

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/mohab19/foodlabelmaker.git
cd foodlabelmaker
```

### 2. Copy `.env` File

```bash
cp .env.example .env
```

Then, edit the `.env` file to match your database and app settings.

### 3. Install Dependencies

```bash
composer install
```

### 4. Generate App Key

```bash
php artisan key:generate
```

---

## Docker Setup

### 1. Start Docker Containers

```bash
./vendor/bin/sail up -d
```

(If you haven't enabled Sail before, run: `php artisan sail:install` and choose MySQL)

### 2. Run Migrations and Seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

This will:
- Create the tables
- Seed 10 users (1 specific user: `user@gmail.com`, password: `password`)
- Seed 1 admin user (email: `admin@gmail.com`, password: `password`)

---

## API Authentication

This project uses **Laravel Sanctum**. After logging in via `/api/user/login` or `/api/admin/login`, you’ll receive a token like:

```json
"token": "2|abc123..."
```

Use this in headers for protected routes:

```http
Authorization: Bearer 2|abc123...
```
You can just use the collection and environment json files sent with the email
---

## Running Tests

### Unit Tests:

```bash
php artisan test --testsuite=Unit
```

### Feature Tests:

```bash
php artisan test --testsuite=Feature
```

---

## Postman API Documentation

You can import the API documentation using the following files:

- **Postman Collection:** `postman/collection.json`
- **Environment File:** `postman/environment.json`

To use:
1. Open Postman
2. Click **Import**
3. Import both files

Login requests will auto-save the returned token to a variable named `token` for use in future requests.

---

## Default Users

### Regular User

- **Email:** `user@gmail.com`
- **Password:** `password`

### Admin User

- **Email:** `admin@gmail.com`
- **Password:** `password`

---

## Useful Commands

```bash
# Rebuild Docker containers if needed
./vendor/bin/sail build --no-cache

# Reset the database
php artisan migrate:fresh --seed
