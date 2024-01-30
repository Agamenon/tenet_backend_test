
## About Tenet Backend Test
This project was create with Laravel Framework v10 and it only for interview proposal.

## User Case

*Create the description of an invoice detailing each consumption of services of the last 15 days, and the corresponding calculation in each of them. Show the total cost of all consumption items*.


*The services are:*

*- BackOffice service. Monthly cost is 7 USD.*

*- Storage service. Cost per unit is USD 0.03 per GB. The formula (cost * total units * billing period) is as follows*

*- Proxy service. Cost per minute is USD 0.03.*

*- Speech translation service. Cost per letter is USD 0.00003.*

*You are free to use any PHP framework, although for us it would be great if it is in Laravel Framework. We will need you to add a Services layer.*


*Finally, add in the Readme file a brief description of what you applied in the test (some design pattern, or SOLID principle, factories, Seeders, unit tests, etc.), add the steps for the installation and the collection of endpoints.*

## Project setup

### First time setup
Install dependencies with:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### Daily usage
After you are in sync with `origin/main` Then you can run
```shell
vendor/bin/sail up -d
vendor/bin/sail shell
composer install
##php artisan db:seed RoleAndPermissionSeeder
```

Inside the shell you can run typical artisan commands like:
```sh
php artisan migrate
php artisan db:seed
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
