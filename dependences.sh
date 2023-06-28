apt-get update -y && apt upgrade -y && apt-get install -y curl openssl zip unzip lsb-release apt-transport-https ca-certificates wget nano
apt-get update -y && apt-get install -y apache2
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list && apt-get update
apt-get update && apt -y install php7.4 php7.4-mysql php7.4-curl php7.4-xml php7.4-intl php7.4-mbstring php7.4-json
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer && apt-get update
chown -R www-data:1000 /var/www/html
a2enmod rewrite # service apache2 restart
