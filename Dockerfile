FROM php:8.1-apache

# Install dependency dasar
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    ca-certificates \
    apt-transport-https \
    unixodbc-dev \
    libgssapi-krb5-2 \
    && rm -rf /var/lib/apt/lists/*

# Tambah Microsoft repo
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
 && curl https://packages.microsoft.com/config/debian/11/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list

# Install SQL Server Driver
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
    msodbcsql18 \
    mssql-tools18

# Install PHP extension sqlsrv
RUN pecl install sqlsrv pdo_sqlsrv \
 && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy source code
COPY . /var/www/html/

WORKDIR /var/www/html

EXPOSE 80
