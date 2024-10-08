## How to use

-   Clone the repository with **git clone**
-   Copy **.env.example** file to **.env** and edit database credentials there
-   Run **composer install**
-   Run **php artisan key:generate**
-   Run **php artisan migrate**
-   Run **php artisan db:seed --class=PermissionSeeder** (it has some seeded data for your testing)
-   Run **php artisan db:seed --class=RoleSeeder** (it has some seeded data for your testing)
-   Run **php artisan db:seed --class=UserSeeder** (it has some seeded data for your testing)
-   That's it: launch the main URL.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
