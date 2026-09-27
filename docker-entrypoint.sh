#!/bin/sh
set -e

echo "==> Clearing cached configuration..."
php artisan config:clear || true

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Linking storage..."
php artisan storage:link || true

PORT_NUM="${PORT:-8080}"
echo "==> Starting server on port $PORT_NUM..."
exec php -S 0.0.0.0:$PORT_NUM -t public/
