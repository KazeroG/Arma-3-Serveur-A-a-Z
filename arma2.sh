#!/bin/bash
wget -N --no-check-certificate https://gameservermanagers.com/dl/linuxgsm.sh && chmod +x linuxgsm.sh && bash linuxgsm.sh arma3server
./arma3server ai
cp -i /lgsm/config-lgsm/arma3server/_default.cfg /lgsm/config-lgsm/arma3server/arma3server.cfg
nano /lgsm/config-lgsm/arma3server/arma3server.cfg
./chmod&&chown.sh
cd /home/arma3
./arma3server ai
