FROM php:8.2-apache

# 1. Instalar y activar la extensión mysqli para conectar con Aiven
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# 2. Copiar todo el código de tu e-commerce al servidor web
COPY . /var/www/html/

# 3. Asegurar que la carpeta exista y darle permisos de escritura a Apache (www-data)
RUN mkdir -p /var/www/html/img/discos \
    && chown -R www-data:www-data /var/www/html/img \
    && chmod -R 775 /var/www/html/img

# 4. Exponer el puerto 80 para que la página sea pública
EXPOSE 80