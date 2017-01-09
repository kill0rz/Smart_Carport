#!/bin/sh

cd /tmp/
mkdir mp3files/
chmod 0777 mp3files/

cd /var/www/html/m/
php m.php >> /root/sh/m.log
