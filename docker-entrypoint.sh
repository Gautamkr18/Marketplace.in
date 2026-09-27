#!/bin/sh

echo "==> Clearing application cache..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "==> Creating storage link..."
php artisan storage:link || true

echo "==> Running database migrations..."
php artisan migrate --force || echo "==> Migration warning: continuing startup..."

PORT_NUM="${PORT:-8080}"
echo "==> Starting Laravel server on 0.0.0.0:$PORT_NUM..."
exec php artisan serve --host=0.0.0.0 --port="$PORT_NUM"
