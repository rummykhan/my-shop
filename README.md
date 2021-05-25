

## Setup

- Clone this repo using `git clone git@github.com:rummykhan/my-shop.git`
- Goto project dir `cd my-shop`
- Create .env file `cp .env.example .env`
- Run `composer install`
- Create app key `php artisan key:generate`
- Update db in `.env`
- Run migrations `php artisan migrate`
- Run category seeder `php artisan db:seed --class=CategorySeeder`
- Run item seeder `php artisan db:seed --class=ItemSeeder`
- Link storage `php artisan storage:link`  
- Run your app using `php -S localhost:1234 -t public`
- Goto browser `http://localhost:1234`, you should see the app.


#### Contact Us
[rehan_manzoor@outlook.com](mailto:rehan_manzoor@outlook.com)
