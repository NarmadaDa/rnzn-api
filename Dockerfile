FROM composer:1 as build

COPY ./src /app
WORKDIR /app
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist

FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pgsql pdo pdo_pgsql
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
# RUN echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1\n" >> /etc/crontabs/root

# RUN touch /var/log/cron.log
COPY ./entrypoint.sh /entrypoint.sh
COPY --from=build /app /app
RUN chmod +x /entrypoint.sh
RUN chown -R www-data:www-data /app
RUN chmod -R 775 /app/bootstrap/cache
RUN chmod -R 775 /app/config
RUN chmod -R 775 /app/storage

WORKDIR /app

USER www-data

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]

