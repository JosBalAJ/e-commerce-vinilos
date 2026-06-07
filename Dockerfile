FROM php:8.2-apache

# Instalar y activar la extensión mysqli para conectar con Aiven
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copiar todo el código de tu e-commerce al servidor web
COPY . /var/www/html/

# Exponer el puerto 80 para que la página sea pública
EXPOSE 80