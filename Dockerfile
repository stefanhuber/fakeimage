FROM php:cli-alpine

RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

EXPOSE 9000

COPY . /var/www/fakeimage
WORKDIR /var/www/fakeimage

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction

CMD [ "php", "-S", "0.0.0.0:9000", "-t", "./public", "./config/server.php" ]