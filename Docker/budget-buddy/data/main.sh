#! /bin/bash

sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php/8.1/apache2/php.ini
a2enmod headers
a2enmod rewrite
cp /var/budget-buddy/main.conf /etc/apache2/sites-available/000-default.conf
/usr/sbin/apache2ctl -D FOREGROUND
