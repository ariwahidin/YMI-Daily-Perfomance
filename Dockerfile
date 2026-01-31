FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    gnupg2 \
    unixodbc-dev \
    curl \
    apt-transport-https

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
 && curl https://packages.microsoft.com/config/debian/11/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18

RUN pecl install sqlsrv pdo_sqlsrv \
 && docker-php-ext-enable sqlsrv pdo_sqlsrv

RUN a2enmod rewrite

WORKDIR /var/www/html
