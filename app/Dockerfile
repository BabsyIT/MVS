# Multi-Arch-Unterstützung hinzufügen
ARG TARGETPLATFORM
FROM --platform=$TARGETPLATFORM php:8.2-apache

# Installiere PHP-Erweiterungen (inkl. PDO MySQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo pdo_mysql

# Arbeitsverzeichnis setzen
WORKDIR /var/www/html

# Kopiere die Anwendung
COPY . /var/www/html

# Setze Dateiberechtigungen effizienter
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponiere Port 80
EXPOSE 80

# Starte den Apache-Server im Vordergrund
CMD ["apache2-foreground"]
