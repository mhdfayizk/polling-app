# Laravel Polling Application

This is a simple polling application built with Laravel 10, Blade, and Tailwind CSS. It allows admins to manage polls and users to vote on them. Results are displayed in real-time using Chart.js.

## Features

- Admin CRUD for polls (Create, Read, Update, Delete)
- User authentication (Login/Register)
- Authenticated users can vote once per poll
- Public view of poll results
- Real-time result updates with AJAX and Chart.js

## Setup Instructions

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/mhdfayizk/polling-app.git](https://github.com/mhdfayizk/polling-app.git)
    cd polling-app
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Set up your environment file:**
    Copy the `.env.example` file to `.env`.
    ```bash
    cp .env.example .env
    ```
    This project is configured to use SQLite by default. To create the database file, run:
    ```bash
    touch database/database.sqlite
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run database migrations and seeders:**
    This will create all necessary tables and seed the database with an admin user, a regular user, and two sample polls.
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Compile frontend assets:**
    ```bash
    npm run dev
    ```

7.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

## Admin Credentials

- **Email:** `admin@example.com`
- **Password:** `password`
