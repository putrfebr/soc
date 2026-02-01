FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

RUN php artisan key:generate
RUN php artisan optimize

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 8080

CMD sh -c "php -S 0.0.0.0:${PORT} -t public"
