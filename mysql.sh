#!/bin/bash
version=$(getconf LONG_BIT)
apt remove gnupg
clear
./update.sh
apt-get -y install --reinstall gnupg2
clear
./update.sh
apt-get -y install dirmngr
clear
./update.sh
apt-get -y install software-properties-common
clear
./update.sh
apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 0xcbcb082a1bb943db
add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://ftp.igh.cnrs.fr/pub/mariadb/repo/10.1/debian jessie main'
clear
./update.sh
apt-get -y install mariadb-server
clear
./update.sh
