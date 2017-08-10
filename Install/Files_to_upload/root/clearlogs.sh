#!/bin/sh

pydf

cd /var/log/
find . -name "*.gz" -type f -delete
find . -name "*.0" -type f -delete
find . -name "*.1" -type f -delete
find . -name "*.log.*" -type f -delete


cd /var/backups/
find . -name "*.gz" -type f -delete
find . -name "*.0" -type f -delete


apt clean


pydf
