FROM php:8.1-apache
RUN docker-php-ext-install mysqli

# Create custom session directory
RUN mkdir -p /var/www/html/sessions && chmod 777 /var/www/html/sessions

# Tell PHP to store sessions in that directory
ENV PHP_SESSION_SAVE_PATH=/var/www/html/sessions

COPY src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
