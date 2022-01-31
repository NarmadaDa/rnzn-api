ARG APP_VERSION

FROM blendstudio.azurecr.io/homeport-api-php as build

FROM nginx:1.17.8-alpine
RUN adduser -D -H -u 82 -s /bin/bash www-data -G www-data
COPY --chown=www-data:www-data --from=build /var/www/html /var/www/html
COPY ./nginx/nginx.conf /etc/nginx/conf.d/default.conf

# RUN find /var/www/html -type f -print0|xargs -0 chmod 644 && find /var/www/html -type d -print0 |xargs -0 chmod 755 && chmod 770 -R /var/www/html/web/sites/default/files;
