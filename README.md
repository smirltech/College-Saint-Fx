# SCOLARITE

> This project runs with Laravel version 9 and PHP 8.1

[Data Modeling](https://drawsql.app/teams/smirltech/diagrams/college-enk)

## Getting started

Assuming you've already installed on your machine: [PHP](https://www.php.net/releases/8.1/en.php) (>=
8.1.0) [Composer](https://getcomposer.org), [MySQL](https://www.mysql.com), [Node.js](https://nodejs.org) and then you
are familiar with [Laravel](https://laravel.com).

``` bash
# install dependencies
composer install
npm install

# create .env file and generate the application key
cp .env.example .env
php artisan key:generate

# build CSS and JS assets
npm run dev
# or, if you prefer minified files
npm run prod
```

Optional: Generate database tables and seeders

``` bash
# database migrations
php artisan migrate

# optional: seed the database
php artisan db:seed 
```

Then launch the server:

``` bash
php artisan serve
```

The Laravel sample project is now up and running! Access it at http://localhost:8000.

## Packages

- [ ] Laravel Sanctum
- [ ] Orion
- [ ] Laravel Permission

## Functionnalities

To see the list of modules and functionalities available, [FUNCTIONALITIES.md](FUNCTIONALITIES.md)
