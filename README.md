# setup

-   copy .env.example to .env
-   touch database/database.sqlite
-   composer install
-   npm install
-   npm run watch
-   php artisan migrate:fresh --seed
-   call asuntos.test and login
-   php artisan serve (if not using valet)

# Run tests

-   composer test -- --filter functionName
-   php artisan test --filter functionName
