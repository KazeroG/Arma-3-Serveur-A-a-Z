#!/bin/bash
adduser arma3
chown -R arma3 /home/arma3
sudo su arma3
su arma3 -c ./arma2.sh
