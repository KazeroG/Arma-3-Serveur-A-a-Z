#!/bin/bash

DELAY=1 # Nombre de secondes pour afficher les résultats

while true; do
  clear
  cat << _EOF_
      Please Select:

          1- Installation Packages
          2- Update
          3- Installation Arma
          4- Installation Composer
          5- Installation Flarum (A revoir)
          6- Installation Ajenti
          0- Quitter
_EOF_

  read -p "Entrez votre sélection... > "

  if [[ $REPLY =~ ^[0-6]$ ]]; then
    case $REPLY in
      1)
        dpkg --add-architecture i386
        apt-get update
        apt-get upgrade
        apt-get dist-upgrade
        apt-get install sudo binutils postfix curl wget file bzip2 gzip unzip bsdmainutils python util-linux ca-certificates tmux lib32gcc1 libstdc++6 libstdc++6:i386
        apt-get install software-properties-common
        apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 0xcbcb082a1bb943db
        add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://ftp.igh.cnrs.fr/pub/mariadb/repo/10.1/debian jessie main'
        apt-get update
        apt-get upgrade
        apt-get dist-upgrade
        apt-get install mariadb-server
        apt-get install apt-transport-https lsb-release ca-certificates
        wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
        echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
        sudo apt-get install python-software-properties software-properties-common
        sudo LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
        sudo apt-get update
        sudo apt-get install php7.0 php7.0-fpm php7.0-mysql -y
        apt-get install apache2
        apt-get install phpmyadmin
        apt-get install libtbb2:i386
        apt-get install lib32z1-dev
        apt-get update
        apt-get upgrade
        apt-get dist-upgrade
        apt-get autoremove
        sudo apt-get --purge autoremove -y
        sleep $DELAY
        continue
        ;;
      2)
        apt-get update
        apt-get upgrade
        apt-get dist-upgrade
        apt-get autoremove
        sleep $DELAY
        continue
        ;;
      3)
        runuser -l root -c "adduser arma3"
        runuser -l root -c "cp /root/config.cfg /home/arma3/arma3server.cfg"
        runuser -l arma3 -c "cd /home/arma3/ | wget -N --no-check-certificate https://gameservermanagers.com/dl/linuxgsm.sh && chmod +x linuxgsm.sh && bash linuxgsm.sh arma3server"
        runuser -l root -c "chown -R arma3 /home/arma3"
        runuser -l arma3 -c "./arma3server ai"
        runuser -l root -c "chown -R arma3 /home/arma3"
        runuser -l root -c "cp /home/arma3/arma3server.cfg /home/arma3/lgsm/config-lgsm/arma3server/arma3server.cfg"
        runuser -l root -c "chown -R arma3 /home/arma3"
        runuser -l arma3 -c "./arma3server ai"
        sleep $DELAY
        continue
        ;;
      4)
        curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
        mv /usr/local/bin/composer.phar /usr/local/bin/composer
        composer update
        sleep $DELAY
        continue
        ;;
      5)
        cd /var/www/html
        mkdir forum
        cd /var/www/html/forum
        composer create-project flarum/flarum . --stability=beta
        composer update
        chmod -R 777 /var/www/html/forum
        sleep $DELAY
        continue
        ;;
      6)
        curl https://raw.githubusercontent.com/ajenti/ajenti/master/scripts/install.sh | sudo bash -s -
        sudo pip install 'setuptools>=0.6rc11' 'pip>=6' wheel
        sudo pip install ajenti-panel ajenti.plugin.dashboard ajenti.plugin.settings ajenti.plugin.plugins ajenti.plugin.filemanager ajenti.plugin.notepad ajenti.plugin.packages ajenti.plugin.services ajenti.plugin.terminal
        sleep $DELAY
        continue
        ;;

      0)
        break
        ;;
    esac
  else
    echo "Entrée invalide."
    sleep $DELAY
  fi
done
echo "Programme quitté"
