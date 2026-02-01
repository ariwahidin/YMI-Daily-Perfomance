# FROM php:8.1-apache

# # Tools dasar
# RUN apt-get update && apt-get install -y \
#     curl \
#     gnupg \
#     ca-certificates \
#     apt-transport-https

# # Tools build untuk pecl
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     autoconf \
#     pkg-config \
#     unixodbc-dev


# RUN curl https://packages.microsoft.com/keys/microsoft.asc \
#  | gpg --dearmor \
#  | tee /usr/share/keyrings/microsoft.gpg > /dev/null

# RUN echo "deb [signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/11/prod bullseye main" \
#  > /etc/apt/sources.list.d/mssql-release.list

# # Install SQL Server Driver
# RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
#     msodbcsql18 \
#     mssql-tools18

# # Install PHP extension sqlsrv
# RUN pecl install sqlsrv pdo_sqlsrv \
#  && docker-php-ext-enable sqlsrv pdo_sqlsrv

# # Enable Apache rewrite
# RUN a2enmod rewrite

# # Copy source code
# COPY . /var/www/html/

# RUN mkdir -p /var/www/html/application/cache/sessions \
#  && chown -R www-data:www-data /var/www/html/application \
#  && chmod -R 755 /var/www/html/application

# WORKDIR /var/www/html

# EXPOSE 80


FROM php:8.1-apache

# Tools dasar
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    ca-certificates \
    apt-transport-https \
    supervisor

# Tools build untuk pecl
RUN apt-get update && apt-get install -y \
    build-essential \
    autoconf \
    pkg-config \
    unixodbc-dev

# Add Microsoft key
RUN curl https://packages.microsoft.com/keys/microsoft.asc \
 | gpg --dearmor \
 | tee /usr/share/keyrings/microsoft.gpg > /dev/null

RUN echo "deb [signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/11/prod bullseye main" \
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


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

# Copy source
COPY . /var/www/html/

RUN composer install --no-dev --optimize-autoloader

# Permission
RUN mkdir -p /var/www/html/application/cache/sessions \
 && chown -R www-data:www-data /var/www/html/application \
 && chmod -R 755 /var/www/html/application

# Copy supervisor config
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord"]

