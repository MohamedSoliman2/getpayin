# getpayin
get pay in task
 I implemented a system where, as soon as a reservation is made, the quantity automatically decreases, and after two minutes, the reservation expires and reverts to its original validity. I also created a table to store all webhooks sent for non-existent orders and added an event to the order creation process to check if a webhook was sent for that order.


    to make it work
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan schedule:work
php artisan queue:work

