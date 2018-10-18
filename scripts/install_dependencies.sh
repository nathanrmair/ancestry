#!/bin/bash
cd /var/www/ancestry
sudo ./composer.phar update
sudo php artisan migrate
cd /var/www
sudo chmod -R 755 ancestry
cd ancestry
sudo chmod -R o+w storage
sudo chmod -R o+w bootstrap