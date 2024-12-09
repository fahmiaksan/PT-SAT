# Getting Started

Welcome to the Laravel API! This guide will help you set up and run the project locally.

---

## Prerequisites

Ensure you have the following tools installed:

- [PHP](https://www.php.net/) (version 8.0 or later)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) or another database supported by Laravel
- [Git](https://git-scm.com/)

---

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/fahmiaksan/PT-SATU-MEDIS.git
   cd PT-SATU-MEDIS
   ```
2. **Install dependencies**:
   ```bash
   composer install
   ```
3. **Set up enviroment variable**:
   ```bash
   cp .env.example .env
   ```
3. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

4. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```
4. **Install JWT**:
   ```bash
   composer require tymon/jwt-auth
   ```
   5. **Publish the JWT configuration**:
   ```bash
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
   ```
6. **Generate JWT secret**:
   ```bash
   php artisan jwt:secret
   ```
6. **Run migration**:
   ```bash
    php artisan migrate
   ```
6. **Run seeder**:
   ```bash
    php artisan db:seed
   ```

## Running the project
1. **Start the local development server**:
   ```bash
   php artisan serve
   ```


   
2. **Access the project: Open your postman and navigate to**:
   ```bash
   http://localhost:8000/yourRequestUrl
   ```
