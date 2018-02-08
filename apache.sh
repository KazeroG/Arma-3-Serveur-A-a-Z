#!/bin/bash
version=$(getconf LONG_BIT)
doc="$PWD"
for file in $doc/*
sudo apt-get -y install apache2.2 libapr1 apache2.2-common apache2-utils apache2-mpm-worker
clear
./update.sh
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod deflate
clear
./update.sh
mkdir $doc/public_html
echo '<?php echo "PHP est actif dans votre public_html"; ?>' > ~/public_html/index.php
clear
./update.sh
chmod -R 755 $doc/public_html
clear
sudo apt-get install memcached
./update.sh
sudo /etc/init.d/apache2 restart
