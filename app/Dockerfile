# Nutze ein Multi-Arch-fähiges Base-Image
ARG TARGETPLATFORM
FROM --platform=$TARGETPLATFORM php:8.2-apache

# Installiere PHP-Erweiterungen mit best practices
RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Arbeitsverzeichnis setzen
WORKDIR /var/www/html

# Kopiere die Anwendung
COPY . /var/www/html

# Setze Dateiberechtigungen effizienter
RUN chown -R www-data:www-data /var/www/html

# Setze korrekte Dateiberechtigungen
RUN chmod -R 755 /var/www/html

# Exponiere Port 80
EXPOSE 80

# Starte den Apache-Server im Vordergrund
CMD ["apache2-foreground"]
