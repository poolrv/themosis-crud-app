FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    default-mysql-client default-libmysqlclient-dev \
    postgresql-client libpq-dev

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mysqli zip

RUN a2enmod rewrite

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/htdocs|g' \
    /etc/apache2/sites-available/000-default.conf

RUN printf '<Directory /var/www/html/htdocs>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html

CMD ["sh", "-c", "\
  echo '⚙️  Esperando a la base de datos...'; \
  until pg_isready -h \"$DATABASE_HOST\" -p \"$DATABASE_PORT\" -U \"$DATABASE_USER\"; do sleep 2; done; \
  echo '✅  BD lista'; \
  cd /var/www/html; \
  if [ ! -d vendor ]; then \
    echo '📦  composer install'; \
    composer install --no-interaction --optimize-autoloader; \
  fi; \
  echo '🧱  Ejecuto migraciones Themosis'; \
  php console migrate --env=production; \
  echo '🚀  Arrancando Apache'; \
  exec apache2-foreground \
"]
