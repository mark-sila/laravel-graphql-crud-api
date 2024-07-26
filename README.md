# Laravel GraphQL CRUD API

Creating API using Laravel GraphQL with Login Authentication.

## Installation

### Dependencies:

* [Laravel 10.0+](https://github.com/laravel/laravel)
* [GraphQL](https://github.com/rebing/graphql-laravel)
* [GraphQL Playground](https://github.com/mll-lab/laravel-graphiql)
* [JWT Auth](https://jwt-auth.readthedocs.io/en/develop/)


### Installation:


#### Composer

Install packages:
```bash
composer install
```

#### Laravel Sail (Docker)


You need to create `.env` from the root folder and copy the content of `.env.example` before you run the command below.

Publish Sail's docker-compose.yml:
```bash
php artisan sail:install
```

Start Sail:
```bash
./vendor/bin/sail up
```
Or
```bash
bash ./vendor/bin/sail up
```

You can completely rebuild your Sail Images:
```bash
docker compose down -v
 
./vendor/bin/sail build --no-cache
 
./vendor/bin/sail up
```

You can learn more about [Laravel Sail](https://laravel.com/docs/11.x/sail).


#### Laravel Artisan Commands

Generate app_key:
```bash
php artisan key:generate
```

Create JWT Secret:
```bash
php artisan jwt:secret
```

Migrate and Seed:
```bash
./vendor/bin/sail artisan migrate --seed
```

Unit Testing:
```bash
./vendor/bin/sail artisan test
```

#### Login Credentials

You can check the available email address from your database.

Password:
```bash
ML85S3f-BP)7W_$
```