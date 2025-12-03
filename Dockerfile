# Dockerfile
FROM php:8.1-apache
RUN docker-php-ext-install mysqli
COPY src/ /var/www/html/
# ensure permissions
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
