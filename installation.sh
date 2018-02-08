#!/bin/bash
version=$(getconf LONG_BIT)
apt-get -y install sudo nano
./update.sh
./chmod&&chown.sh
clear
./depend.sh
clear
./php.sh
clear
./mysql.sh
clear
./update.sh
clear
./phpmyadmin
clear
./update.sh
clear
