#!/bin/bash
set -euo pipefail

cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
    cp .env.hostinger.example .env
    echo "Created .env from .env.hostinger.example"
fi

mkdir -p \
    bootstrap/cache \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    public/storage \
    database

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

chmod -R ug+rw bootstrap/cache storage database public/storage || true

php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Hostinger setup finished. Change the admin password immediately."
echo "Login: /login  —  admin@gmac.coffee  —  password"
echo "Set MAIL_PASSWORD in .env to the info@gmac.coffee mailbox password, then: php artisan config:clear"
