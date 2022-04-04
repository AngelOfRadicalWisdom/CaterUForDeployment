This Project is the administrator side of an automated menu or ordering system. It is impleted using Php
with Laravel Framework with a bit of Javascript. The administrator's function is add the necessary details like
the menus, promotions and etc. It also predicts the restaurants best sellers using Apriori Algorithm.

To run the project locally please follow the steps
1. Clone or download the "master" branch. Make sure to modify the .env.example to .env and make necessary changes to the database configuration.
2. Run php artisan install command
3. Run composer dumpautoload command
4. Run php artisan migrate command 
5. Run php artisan seed --class="classname"
For Seeders seed in this Order 
*category
*customerseeder
*EmployeeSeeder
*subcategory
*menu
*RatingsSeeder
*TableSedder
*orderSeeder2
*orderSeeder
6. Run php artisan passport:install
7. Run php artisan serve

Happy Viewing
