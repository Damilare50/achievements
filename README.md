This repository contains a full-stack application with a Laravel backend server and a Next.js client.

**Project Structure**

- `/server` — Laravel API backend
- `/client` — Next.js frontend application

## Client Setup (Next.js)

Instructions for getting the Next.js client running locally after pulling from GitHub.

**Prerequisites**

- Node.js 18+

**Quick local setup**

1. Navigate to the client directory:

```bash
cd client
```

2. Install dependencies:

```bash
npm install
```

3. Configure environment variables (if needed):

```bash
cp .env.example .env.local
```

Update `.env.local` with 'NEXT_PUBLIC_API_BASE_URL', your API endpoint (typically `http://127.0.0.1:8000/api` for the local server).

4. Start the development server:

```bash
npm run dev
```

The client will be available at http://localhost:3000.

---

## Server Setup

This document explains how to get the Laravel-based `server` running locally after pulling the repository.

**Prerequisites**

- PHP 8.2+ with common extensions (pdo, mbstring, openssl, tokenizer, xml, ctype, json)
- Composer

**Quick local setup (recommended for a simple local dev)**

1. Open a terminal and change into the server directory:

```bash
cd server
```

2. Install PHP dependencies:

```bash
composer run setup
```

This will install dependencies, copy the example env file, generate the app key, run migrations and seed the database.

3. Start the local dev server:

```bash
php artisan serve
```

The API will be available at http://127.0.0.1:8000.

**Useful files**

- Composer config: [server/composer.json](composer.json)
- Routes (API): [server/routes/api.php](routes/api.php)

**Troubleshooting**

- If migrations fail, check DB variable in `.env` and ensure the DB server is reachable.
- If `php artisan` commands error, ensure PHP extensions required by Laravel are installed.\
- For other issues, refer to the [Laravel documentation](https://laravel.com/docs).

**API Quick Usage — Create user, Login, Trigger Purchase**

Below are minimal cURL examples demonstrating how to create a user, obtain an authentication token, and trigger a purchase against the API.

- Create a user (register):

```bash
curl -X POST http://127.0.0.1:8000/api/create \
	-H "Content-Type: application/json" \
	-d '{"name":"Alice","email":"alice@example.com","password":"secret"}'

# Example:
# { "user": "<USER_OBJECT>", "token": "SOME_TOKEN_VALUE" }
```

- Login and capture token :

```bash
curl -X POST http://127.0.0.1:8000/api/login \
	-H "Content-Type: application/json" \
	-d '{"email":"alice@example.com","password":"secret"}'

# Example response (adjust extraction depending on actual response shape):
# { "user": "<USER_OBJECT>", "token": "SOME_TOKEN_VALUE" }
```

- Trigger a purchase (authenticated request): Use this to check if the events are triggered correctly.

```bash
# Replace SOME_TOKEN_VALUE with the token returned by the login step
curl -X POST http://127.0.0.1:8000/api/purchase \
	-H "Content-Type: application/json" \
	-H "Authorization: Bearer SOME_TOKEN_VALUE"
```

- Get user achievements (authenticated request):

```bash
# Replace SOME_TOKEN_VALUE with the token returned by the login step
curl -X GET http://127.0.0.1:8000/api/user/{USER_ID}/achievements \
	-H "Authorization: Bearer SOME_TOKEN_VALUE"

# Example response:
# [ 'unlocked_achievements': '', 'next_available_achievements': '','current_badge': '', 'next_badge': '', 'remaining_to_unlock_next_badge': '']
```
