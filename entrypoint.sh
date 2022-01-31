#!/bin/sh

cd /var/www/html

# chown -R www-data:www-data /app
#chmod -R 775 /app/{config,storage,bootstrap/cache}

cp /var/www/html/.env.example /var/www/html/.env
# php artisan key:generate
php artisan optimize

# TODO: do not include these commands in production 😂
#php artisan test #--verbose
# php artisan migrate:rollback
# php artisan migrate
# php artisan db:seed
# php artisan passport:install --uuids --force
# php artisan passport:keys

# ---------------------------------------------------

php-fpm
