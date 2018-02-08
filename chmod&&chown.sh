#!/bin/sh
for file in $PWD/*
do
  chmod -R 777 $PWD \;
  chown -R root $PWD \;
done
clear
