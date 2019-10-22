FROM php:7.3-fpm

RUN  apt-get update && apt-get install -y wget

RUN apt-get update && apt-get install -y zlib1g-dev git libpng-dev libxml2-dev default-mysql-client libzip-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql zip bcmath soap pcntl sockets

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN wget -O phpunit https://phar.phpunit.de/phpunit-7.phar && \
    chmod +x phpunit && mv phpunit /usr/local/bin/phpunit

ARG xdebug_remote_host
ARG xdebug_remote_port
RUN echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_host='$xdebug_remote_host >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_port='$xdebug_remote_port >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_autostart=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chown -R www-data:www-data /var/www
ENV PATH /var/www/html/bin:$PATH

EXPOSE 9000