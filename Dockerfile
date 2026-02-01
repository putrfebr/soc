FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

COPY . .

RUN npm install && npm run build
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
