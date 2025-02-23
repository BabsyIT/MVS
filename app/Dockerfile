FROM php:8.2-apache

# Installiere PHP-Erweiterungen
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Arbeitsverzeichnis setzen
WORKDIR /var/www/html

# Kopiere die Anwendung
COPY . /var/www/html

# Setze Dateiberechtigungen
RUN chown -R www-data:www-data /var/www/html

# Exponiere Port 80
EXPOSE 80
