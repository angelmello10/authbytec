FROM php:8.3-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos
COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html