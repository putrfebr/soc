FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN npm install && npm run build
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD sh -c "php artisan serve --host=0.0.0.0 --port=$PORT"
