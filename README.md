# Laravel+Vue Crud Starter

[![Build Status](https://dev.azure.com/anowarhossain/laravel-vue-crud-starter/_apis/build/status/AnowarCST.laravel-vue-crud-starter?branchName=master)](https://dev.azure.com/anowarhossain/laravel-vue-crud-starter/_build/latest?definitionId=6&branchName=master)

## Tech Specification

- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5
- PHPUnit Test Case/Test Coverage

## Installation

- Склонировать данный репозиторий
- `composer install`
- `cp .env.example .env`
- Изменить настройки подключения к базе данных в файле .env
- php artisan storage:link
- Скопировать статику в \public\storage
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- `npm install`
- `npm run watch-poll(для разработки)`
- `php artisan serve`

## Install with Docker

- `docker-compose up -d`
- `docker exec -it vue-starter /bin/bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- Application http://localhost:8008/
- Adminer for Database http://localhost:8080/
- DBhost: yourIP:3307, user: root, Password: 123456

## Unit Test

#### run PHPUnit

```bash
# run PHPUnit all test cases
vendor/bin/phpunit
# or Feature test only
vendor/bin/phpunit --testsuite Feature
```

#### Code Coverage Report

```bash
# reports is a directory name
vendor/bin/phpunit --coverage-html reports/
```

A `reports` directory has been created for code coverage report. Open the dashboard.html.

## License

[MIT license](https://opensource.org/licenses/MIT).
