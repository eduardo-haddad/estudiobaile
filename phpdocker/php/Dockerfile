FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update \
    && apt-get -y install php7.2-gd \
    && apt-get -y install phpmyadmin php-mbstring php7.1-mcrypt php-gettext \
    && ln -s /etc/php/7.1/mods-available/mcrypt.ini /etc/php/7.2/mods-available \
    && ln -s /etc/php/7.1/mods-available/mcrypt.ini /etc/php/7.3/mods-available \
    && phpenmod mcrypt \
    && phpenmod mbstring