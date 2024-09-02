#!/usr/bin/dumb-init /bin/bash

cd /home/ubuntu/theshit_php/

sudo -u ubuntu php artisan cache:clear
sudo -u ubuntu php artisan view:clear
sudo -u ubuntu php artisan route:clear
sudo -u ubuntu php artisan clear-compiled
sudo -u ubuntu php artisan config:cache

sudo -u ubuntu php artisan migrate --path="/database/Migrations" --force

/usr/sbin/php-fpm8.1 -D -O --fpm-config /etc/php/8.1/fpm/php-fpm.conf &

nginx -g "daemon off;"