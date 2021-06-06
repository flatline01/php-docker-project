FROM php:fpm
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd
#RUN docker-php-ext-install mysqli
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN pecl install xdebug && docker-php-ext-enable xdebug
