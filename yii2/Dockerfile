FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    docker-php-ext-install pdo pdo_mysql && \
    a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/web

COPY . /var/www/html/

WORKDIR /var/www/html/


RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

EXPOSE 80