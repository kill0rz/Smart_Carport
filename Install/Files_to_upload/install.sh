#!/bin/sh

echo ">>>> Adding externel repo for php7.1..."
echo "deb http://repozytorium.mati75.eu/raspbian/ jessie-backports main contrib non-free" >> /etc/apt/sources.list
gpg --keyserver pgpkeys.mit.edu --recv-key CCD91D6111A06851
gpg --armor --export CCD91D6111A06851 | apt-key add -

echo ">>>> Removing old php versions..."
apt remove php5* php7.0* -y

echo ">>>> Updating installed packages..."
apt update && apt -y upgrade && apt -y dist-upgrade && apt -y autoremove

echo ">>>> Installing required and optional software..."
apt install -y pydf screen nano apache2 mariadb-server mariadb-client phpmyadmin git-core mpg123 htop mutt php7.1 php7.1-curl php7.1-gd php7.1-fpm php7.1-cli php7.1-opcache php7.1-mbstring php7.1-xml php7.1-zip

echo ">>>> Installing WiringPi..."
cd && git clone git://git.drogon.net/wiringPi
cd ~/wiringPi
git pull origin
./build

echo ">>>> Setting permissions..."
cd /root/ && chmod 0777 *.sh
cd /root/sh/ && chmod 0777 *.sh
cd /var/www/html/timecontrol/ && chmod 0777 *.data

echo ">>>> Creating and importing databses..."
mysql -uroot -p < /tmp/pi_dbs.sql

echo ">>>> Creating new crontab..."
(crontab -l 2>/dev/null; echo "#@reboot /root/sh/button.sh") | crontab -
(crontab -l 2>/dev/null; echo "@reboot /root/sh/m.sh") | crontab -
(crontab -l 2>/dev/null; echo "@reboot /root/sh/timecontrol.sh") | crontab -
(crontab -l 2>/dev/null; echo "@reboot /root/sh/zsh.sh") | crontab -

echo ">>>> Restarting services..."
service mysql restart
service apache2 restart

echo ">>>> Cleaning up..."
apt-get autoremove -y
apt-get clean

echo ">>>> Almost done! Now follow instructions from install.txt!"