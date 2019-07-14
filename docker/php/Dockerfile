FROM php:7.2-fpm

# Install extensions
RUN apt-get update
RUN apt-get install -y libicu-dev zip unzip curl zlib1g-dev libpng-dev vim procps \
	&& docker-php-ext-install intl opcache \
	&& docker-php-ext-enable intl opcache \
	&& docker-php-ext-install pdo pdo_mysql mysqli\
	&& docker-php-ext-install mbstring \
	&& pecl install xdebug-2.7.1 \
	&& docker-php-ext-enable xdebug \
	&& docker-php-ext-install gd

# using variables
ARG www_user
ARG www_password
ARG NODE_VERSION

ENV NVM_DIR $NVM_DIR

# add user
RUN useradd -ms /bin/bash $www_user \
	&& echo "${www_user}:${www_password}" | chpasswd

# Install Git
RUN apt-get install -y git

# Install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN chown -R $www_user:www-data /var/www/ \
	&& chown www-data -R /var/run/ \
	&& chown www-data -R /var/log/

WORKDIR /var/www/app

# install Nodejs
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash
RUN export NVM_DIR=$HOME/.nvm && . $HOME/.nvm/nvm.sh \
	&& nvm install $NODE_VERSION \
	&& nvm use $NODE_VERSION

COPY ./.bashrc ~/.bashrc