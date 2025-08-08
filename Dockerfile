FROM php:8.2-apache

# Modules utiles PDO pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copie du code
COPY ./src/ /var/www/html/

# Droits
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
