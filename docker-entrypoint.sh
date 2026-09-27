#!/bin/sh

echo "==> Setting up storage and cache permissions..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 777 storage bootstrap/cache

echo "==> Clearing application cache..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "==> Creating storage link..."
php artisan storage:link || true

echo "==> Running database migrations..."
php artisan migrate --force || echo "==> Migration check complete..."

echo "==> Auto-seeding initial categories & data..."
php artisan db:seed --force || echo "==> Seeding check complete..."

PORT_NUM="${PORT:-8080}"
echo "==> Starting production web server on 0.0.0.0:$PORT_NUM..."
exec php -S 0.0.0.0:"$PORT_NUM" server.php
