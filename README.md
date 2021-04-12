
## My Shop

This is a test project to reference during my Youtube videos, feel free to use it, create issues, I'll try to address them in my videos.


## Database Seeding

1. I've included real data from an ecommerce store in xml format located at `storage/app/catalog/catalog.xml`, feel free to play around with it.
2. By default when you run `php artisan db:seed` it will seed around 3 categories & 900 products, you can limit these by editing the total in `ItemSeeder` placed in `database/seeders/ItemSeeder.php`

## How to Setup

- Clone this repo using `git clone git@github.com:rummykhan/my-shop.git`
- Goto project dir `cd my-shop`
- Create .env file `cp .env.example .env`
- Run `composer install`
- Create app key `php artisan key:generate`
- Update db in `.env`
- Run migrations `php artisan migrate`
- Run item seeder `php artisan db:seed`
- Link storage `php artisan storage:link`  
- Run your app using `php -S localhost:1234 -t public`
- Goto browser `http://localhost:1234`, you should see the app.





#### Contact Us
[rehan_manzoor@outlook.com](mailto:rehan_manzoor@outlook.com)
