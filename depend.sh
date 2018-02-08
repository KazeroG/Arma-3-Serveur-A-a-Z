#!/bin/bash
version=$(getconf LONG_BIT)
./update.sh
dpkg --add-architecture i386;
clear
./update.sh
apt-get install binutils postfix curl wget file bzip2 gzip unzip bsdmainutils python util-linux ca-certificates tmux lib32gcc1 libstdc++6 libstdc++6:i386
./update.sh
