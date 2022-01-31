
ARG APP_VERSION

FROM composer:1 as build

COPY ./src/database/ database/
COPY ./src/composer.json composer.json
COPY ./src/composer.lock composer.lock
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist --no-dev --optimize-autoloader

FROM php:7.4.15-fpm-alpine3.13

RUN set -ex; \
	\
    apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \  
        # libxml2-dev \
    &&  apk add --no-cache \
        freetype-dev \
		libgomp \
		imagemagick-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		libzip-dev \
        postgresql-dev \
        libmcrypt-dev \
    &&  pecl install mcrypt \
    &&  pecl install imagick \
    &&  docker-php-ext-enable mcrypt \
    &&  docker-php-ext-install bcmath pdo_pgsql \
    &&  docker-php-ext-configure gd --with-freetype --with-jpeg \
    &&  docker-php-ext-install gd \
    &&  docker-php-ext-enable imagick \
    &&  apk del .build-deps

COPY ./entrypoint.sh /entrypoint.sh
COPY --chown=www-data:www-data --from=build /app/ /var/www/html/
COPY --chown=www-data:www-data ./src /var/www/html/
# RUN echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1\n" >> /etc/crontabs/root

# RUN touch /var/log/cron.log
RUN chmod +x /entrypoint.sh
RUN chmod -R 775 /var/www/html/bootstrap/cache && chmod -R 775 /var/www/html/config && chmod -R 775 /var/www/html/storage

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

ENTRYPOINT ["/entrypoint.sh"]

# FROM php:7.4-fpm

# RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pgsql pdo pdo_pgsql
# RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

# RUN printf "\n" | pecl install imagick
# RUN docker-php-ext-enable imagick

# COPY ./entrypoint.sh /entrypoint.sh
# COPY --chown=www-data:www-data --from=build /app/ /var/www/html/
# COPY --chown=www-data:www-data ./src /var/www/html/

# RUN chmod +x /entrypoint.sh
# RUN chmod -R 775 /var/www/html/bootstrap/cache
# RUN chmod -R 775 /var/www/html/config
# RUN chmod -R 775 /var/www/html/storage

# ENTRYPOINT ["/entrypoint.sh"]

