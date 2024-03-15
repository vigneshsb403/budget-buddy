#! /bin/bash

sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php/8.1/apache2/php.ini
sed -i "s/memory_limit = .*/memory_limit = 256M/g" /etc/php/8.1/apache2/php.ini

a2enmod headers
a2enmod rewrite
cp /var/budget-buddy/main.conf /etc/apache2/sites-available/000-default.conf
mkdir /var/www/project/
 cp /var/budget-buddy/photogramconfig.json /var/www/project/photogramconfig.json
/usr/sbin/apache2ctl -D FOREGROUND
