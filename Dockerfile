FROM php:8.2-cli

# Instala extensiones si las necesitas
RUN apt-get update && apt-get install -y \
    unzip \
    && docker-php-ext-install pdo_mysql

# Copia el contenido del proyecto
COPY . /app
WORKDIR /app

# Comando de inicio
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
