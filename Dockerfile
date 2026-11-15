# ---------- Stage 1: build CSS/JS with Node ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package*.json .npmrc* ./
RUN npm install
COPY . .
RUN npm run build

# ---------- Stage 2: PHP app ----------
FROM php:8.4-cli
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel needs these folders to exist and be writable
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database \
    && sed -i 's/\r$//' docker-entrypoint.sh \
    && chmod +x docker-entrypoint.sh

EXPOSE 10000
CMD ["./docker-entrypoint.sh"]
