#!/bin/sh
set -e

if [ "$1" = "horizon" ]; then
  php artisan horizon
else
  /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
fi
