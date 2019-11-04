# TheRegister.co.uk feed viewer
TheRegister.co.uk feed viewer built using Lumen and VueJS.

## Requirements
* PHP (>7.2)
* NodeJS (>8)
* MySQL (>5.6)

## Installation
- Copy `.env.example` to `.env`
- Edit `.env` to set database connection details, APP_URL and MIX_API_URL
(it should be the same as APP_URL, with /api in the end)
- Run `composer install`
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `php artisan jwt:secret`
- Run `yarn install`
- Run `yarn run prod`


- Run `php artisan db:seed --class="TestUserSeeder"` to have a test user with
credentials: info@example.com : test123

