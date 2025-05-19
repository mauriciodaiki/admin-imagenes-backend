FROM php:8.2-cli

# Instalar herramientas necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    zip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear carpeta de la app
WORKDIR /app

# Copiar el contenido del proyecto
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Puerto y comando de inicio
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
